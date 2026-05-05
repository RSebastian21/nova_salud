<?php

class Product extends Model
{
    public function all(): array
    {
        $sql = 'SELECT products.*, categories.name AS category_name
                FROM products
                INNER JOIN categories ON categories.id = products.category_id
                ORDER BY products.id DESC';
        return $this->db->query($sql)->fetchAll();
    }

    public function available(): array
    {
        $stmt = $this->db->query('SELECT * FROM products WHERE stock > 0 ORDER BY name ASC');
        return $stmt->fetchAll();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM products WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        return $product ?: null;
    }

    public function create(array $data): bool
    {
        $stmt = $this->db->prepare(
            'INSERT INTO products (name, price, stock, category_id)
             VALUES (:name, :price, :stock, :category_id)'
        );

        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'category_id' => $data['category_id'],
        ]);
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare(
            'UPDATE products
             SET name = :name, price = :price, stock = :stock, category_id = :category_id
             WHERE id = :id'
        );

        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'category_id' => $data['category_id'],
        ]);
    }

    public function updateStock(int $id, int $stock): bool
    {
        $stmt = $this->db->prepare('UPDATE products SET stock = :stock WHERE id = :id');
        $stmt->bindValue('id', $id, PDO::PARAM_INT);
        $stmt->bindValue('stock', $stock, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM products WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }

    public function lowStock(int $limit = 10): array
    {
        $stmt = $this->db->prepare(
            'SELECT products.*, categories.name AS category_name
             FROM products
             INNER JOIN categories ON categories.id = products.category_id
             WHERE products.stock < :limit
             ORDER BY products.stock ASC'
        );
        $stmt->bindValue('limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function countAll(): int
    {
        return (int) $this->db->query('SELECT COUNT(*) FROM products')->fetchColumn();
    }
}