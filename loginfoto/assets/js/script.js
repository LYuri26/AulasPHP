document.addEventListener("DOMContentLoaded", function () {
  // Função para alternar visibilidade da senha
  function setupPasswordToggle() {
    document.querySelectorAll(".toggle-password").forEach((button) => {
      button.addEventListener("click", function () {
        const input = this.previousElementSibling;
        const icon = this.querySelector("i");
        const type =
          input.getAttribute("type") === "password" ? "text" : "password";

        input.setAttribute("type", type);
        icon.classList.toggle("fa-eye");
        icon.classList.toggle("fa-eye-slash");
      });
    });
  }

  // Função para calcular força da senha
  function calculatePasswordStrength(password) {
    let strength = 0;

    if (password.length >= 8) strength++;
    if (password.length >= 12) strength++;
    if (password.match(/[a-z]/)) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^a-zA-Z0-9]/)) strength++;

    return Math.min(100, strength * 20);
  }

  // Função para atualizar o indicador de força da senha
  function updatePasswordStrength(passwordInput, strengthBar) {
    const strength = calculatePasswordStrength(passwordInput.value);

    strengthBar.style.width = strength + "%";

    if (strength < 30) {
      strengthBar.className = "progress-bar bg-danger";
    } else if (strength < 70) {
      strengthBar.className = "progress-bar bg-warning";
    } else {
      strengthBar.className = "progress-bar bg-success";
    }
  }

  // Função para validar confirmação de senha
  function setupPasswordConfirmation(passwordInput, confirmInput) {
    confirmInput.addEventListener("input", function () {
      if (this.value !== passwordInput.value) {
        this.setCustomValidity("As senhas não coincidem");
      } else {
        this.setCustomValidity("");
      }
    });
  }

  // Configurações iniciais
  setupPasswordToggle();

  // Configurar força da senha para o formulário de registro
  const regPasswordInput = document.getElementById("reg_password");
  const regStrengthBar = document.getElementById("password-strength-bar");
  const regConfirmInput = document.getElementById("reg_confirm_password");

  if (regPasswordInput && regStrengthBar) {
    regPasswordInput.addEventListener("input", function () {
      updatePasswordStrength(this, regStrengthBar);
    });

    if (regConfirmInput) {
      setupPasswordConfirmation(regPasswordInput, regConfirmInput);
    }
  }

  // Limpar modal quando fechado
  const registerModal = document.getElementById("registerModal");
  if (registerModal) {
    registerModal.addEventListener("hidden.bs.modal", function () {
      const form = this.querySelector("form");
      if (form) {
        form.reset();
        form.classList.remove("was-validated");

        if (regStrengthBar) {
          regStrengthBar.style.width = "0%";
          regStrengthBar.className = "progress-bar";
        }
      }
    });
  }

  // Validação de formulários
  document.querySelectorAll(".needs-validation").forEach((form) => {
    form.addEventListener(
      "submit",
      function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      },
      false
    );
  });
});
