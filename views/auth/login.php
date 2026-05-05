<!-- Fondo neutro premium -->
<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height: 100vh; background: radial-gradient(circle at top, rgba(22, 163, 74, 0.12), transparent 38%), #eff6ff;">
    <div class="col-12 col-sm-10 col-md-8 col-lg-5 col-xl-4">

        <!-- Tarjeta con sombreado de contorno moderno -->
        <div class="card border-0" style="border-radius: 2.25rem; background: rgba(255,255,255,0.98); box-shadow: 0 28px 80px rgba(15, 23, 42, 0.12);">
            <div class="card-body p-4 p-md-5">

                <!-- Encabezado con tu color de identidad #1e293b -->
                <div class="text-center mb-5">
                    <div class="d-inline-flex align-items-center justify-content-center mb-3 shadow-sm"
                        style="width: 68px; height: 68px; background-color: #1e293b; border-radius: 18px;">
                        <i class="bi bi-capsule-pill text-white fs-2"></i>
                    </div>
                    <h2 class="h4 fw-bold mb-1" style="color: #1e293b; letter-spacing: -0.5px;">NovaSalud</h2>
                    <p class="text-muted small fw-semibold" style="letter-spacing: 1px; font-size: 0.75rem;">Gestión Farmacéutica</p>
                </div>

                <form method="post" action="<?= url('authenticate') ?>">

                    <!-- Input Usuario -->
                    <div class="mb-4">
                        <label class="form-label small fw-bold mb-2 ms-1 d-flex align-items-center gap-2" style="color: #64748b;">
                            <i class="bi bi-person"></i>
                            CORREO ELECTRÓNICO
                        </label>

                        <input type="email" name="email" class="form-control custom-input"
                            value="admin@novasalud.com" required>
                    </div>

                    <!-- Input Clave -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-2 ms-1">
                            <label class="form-label small fw-bold mb-0 d-flex align-items-center gap-2" style="color: #64748b;">
                                <i class="bi bi-shield-lock"></i>
                                CONTRASEÑA
                            </label>

                            <a href="#" class="small text-decoration-none fw-semibold" style="color: #1e293b;">
                                ¿Olvidaste tu clave?
                            </a>
                        </div>

                        <div class="position-relative">
                            <input type="password" name="password" id="passwordField"
                                class="form-control custom-input pe-5"
                                value="admin123" required>

                            <!-- OJITO dentro del input -->
                            <button type="button" id="togglePassword" class="eye-btn" aria-label="Mostrar contraseña">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Botón Principal con tu color #1e293b -->
                    <button type="submit" class="btn w-100 py-3 fw-bold text-white mb-4 shadow-sm"
                        style="background-color: #1e293b; border-radius: 14px; border: none; transition: all 0.3s ease;">
                        INICIAR SESIÓN SEGURA
                    </button>

                    <div class="text-center">
                        <span class="badge rounded-pill fw-normal px-3 py-2" style="background-color: #f1f5f9; color: #475569;">
                            <i class="bi bi-shield-check me-1"></i> Use sus credenciales autorizadas para acceder
                        </span>
                    </div>

                </form>
            </div>
        </div>

        <div class="text-center mt-4">
            <p class="text-muted small">&copy; 2026 NovaSalud &middot;</p>
        </div>

    </div>
</div>

<style>
    /* Estilo de los inputs mejorado */
    .custom-input {
        width: 100%;
        padding: 1rem 1rem;
        border-radius: 1rem;
        border: 1px solid #d2d8e0;
        background-color: #f8fafc;
        color: #1e293b;
        transition: border-color 0.25s ease, box-shadow 0.25s ease, transform 0.25s ease;
    }

    .custom-input:focus {
        border-color: #16a34a;
        background-color: #ffffff;
        box-shadow: 0 0 0 0.3rem rgba(22, 163, 74, 0.12);
        outline: none;
        transform: translateY(-1px);
    }

    .eye-btn {
        position: absolute;
        top: 50%;
        right: 0.85rem;
        transform: translateY(-50%);
        border: none;
        background: rgba(15, 23, 42, 0.04);
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        transition: background 0.2s ease, color 0.2s ease;
    }

    .eye-btn:hover {
        background: rgba(15, 23, 42, 0.1);
        color: #1e293b;
    }

    .custom-input:disabled,
    .custom-input[readonly] {
        background-color: #f1f5f9;
    }

    /* Efectos del Botón */
    .btn.w-100 {
        box-shadow: 0 18px 40px rgba(22, 163, 74, 0.18);
    }

    .btn.w-100:hover {
        background-color: #0f172a !important;
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(15, 23, 42, 0.2) !important;
    }

    .form-control:focus {
        box-shadow: none !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const passwordField = document.getElementById('passwordField');

        if (!togglePassword || !passwordField) {
            return;
        }

        togglePassword.addEventListener('click', function() {
            const isPassword = passwordField.type === 'password';
            passwordField.type = isPassword ? 'text' : 'password';
            const icon = this.querySelector('i');
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
            this.setAttribute('aria-label', isPassword ? 'Ocultar contraseña' : 'Mostrar contraseña');
        });
    });
</script>