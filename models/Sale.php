<?php

class Sale extends Model
{
    public function all(): array
    {
        $sql = 'SELECT sales.*, users.name AS user_name
                FROM sales
                INNER JOIN users ON users.id = sales.user_id
                ORDER BY sales.id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM sales')->fetchColumn();
    }

    public function totalRevenue(): float
    {
        return (float) $this->db->query('SELECT COALESCE(SUM(total), 0) FROM sales')->fetchColumn();
    }

    public function details(int $saleId): array
    {
        $stmt = $this->db->prepare(
            'SELECT sale_details.*, products.name AS product_name
             FROM sale_details
             INNER JOIN products ON products.id = sale_details.product_id
             WHERE sale_details.sale_id = :sale_id'
        );
        $stmt->execute(['sale_id' => $saleId]);

        return $stmt->fetchAll();
    }

    public function create(array $items, int $userId): int
    {
        $this->db->beginTransaction();

        try {
            $normalizedItems = [];
            $total = 0;

            foreach ($items as $item) {
                $productId = (int) $item['product_id'];
                $quantity = (int) $item['quantity'];

                if ($productId <= 0 || $quantity <= 0) {
                    continue;
                }

                $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id FOR UPDATE');
                $stmt->execute(['id' => $productId]);
                $product = $stmt->fetch();

                if (!$product) {
                    throw new Exception('Producto no encontrado.');
                }

                if ((int) $product['stock'] < $quantity) {
                    throw new Exception('Stock insuficiente para ' . $product['name'] . '.');
                }

                $price = (float) $product['price'];
                $subtotal = $price * $quantity;
                $total += $subtotal;

                $normalizedItems[] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ];
            }

            if (count($normalizedItems) === 0) {
                throw new Exception('Agrega al menos un producto a la venta.');
            }

            $stmt = $this->db->prepare('INSERT INTO sales (user_id, total) VALUES (:user_id, :total)');
            $stmt->execute(['user_id' => $userId, 'total' => $total]);
            $saleId = (int) $this->db->lastInsertId();

            foreach ($normalizedItems as $item) {
                $detailStmt = $this->db->prepare(
                    'INSERT INTO sale_details (sale_id, product_id, quantity, price, subtotal)
                     VALUES (:sale_id, :product_id, :quantity, :price, :subtotal)'
                );
                $detailStmt->execute([
                    'sale_id' => $saleId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                $stockStmt = $this->db->prepare(
                    'UPDATE products SET stock = stock - :quantity WHERE id = :product_id'
                );
                $stockStmt->bindValue('quantity', $item['quantity'], PDO::PARAM_INT);
                $stockStmt->bindValue('product_id', $item['product_id'], PDO::PARAM_INT);
                $stockStmt->execute();
            }

            $this->db->commit();
            return $saleId;
        } catch (Throwable $exception) {
            $this->db->rollBack();
            throw $exception;
        }
    }
}