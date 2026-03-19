/**
 * AJAX Utilities - Fonctions pour les requêtes asynchrones
 */

// Configuration globale
const AJAX_CONFIG = {
  timeout: 30000,
  headers: {
    "Content-Type": "application/json",
  },
};

/**
 * Effectue une requête GET asynchrone
 * @param {string} url - L'URL de la requête
 * @param {function} onSuccess - Callback en cas de succès
 * @param {function} onError - Callback en cas d'erreur
 */
async function ajaxGet(url, onSuccess, onError) {
  try {
    const response = await fetch(url, {
      method: "GET",
      headers: AJAX_CONFIG.headers,
    });

    if (!response.ok) {
      throw new Error(`Erreur HTTP: ${response.status}`);
    }

    const data = await response.json();
    if (onSuccess) onSuccess(data);
  } catch (error) {
    console.error("Erreur AJAX GET:", error);
    if (onError) onError(error);
  }
}

/**
 * Effectue une requête POST asynchrone
 * @param {string} url - L'URL de la requête
 * @param {object} data - Les données à envoyer
 * @param {function} onSuccess - Callback en cas de succès
 * @param {function} onError - Callback en cas d'erreur
 */
async function ajaxPost(url, data, onSuccess, onError) {
  try {
    const response = await fetch(url, {
      method: "POST",
      headers: AJAX_CONFIG.headers,
      body: JSON.stringify(data),
    });

    if (!response.ok) {
      throw new Error(`Erreur HTTP: ${response.status}`);
    }

    const result = await response.json();
    if (onSuccess) onSuccess(result);
  } catch (error) {
    console.error("Erreur AJAX POST:", error);
    if (onError) onError(error);
  }
}

/**
 * Ajoute un favori via AJAX
 * @param {number} itemId - ID de l'élément
 * @param {string} itemType - Type d'élément (livre, mooc, etc.)
 * @param {function} onSuccess - Callback en cas de succès
 * @param {function} onError - Callback en cas d'erreur
 */
function addFavorite(itemId, itemType, onSuccess, onError) {
  ajaxPost(
    "index.php?action=add_favori",
    { id: itemId, type: itemType },
    onSuccess,
    onError,
  );
}

/**
 * Retire un favori via AJAX
 * @param {number} favoriteId - ID du favori
 * @param {function} onSuccess - Callback en cas de succès
 * @param {function} onError - Callback en cas d'erreur
 */
function removeFavorite(favoriteId, onSuccess, onError) {
  ajaxPost(
    "index.php?action=remove_favori",
    { id: favoriteId },
    onSuccess,
    onError,
  );
}

/**
 * Charge plus de contenu (pagination infinie)
 * @param {string} url - URL pour charger plus de contenu
 * @param {function} onSuccess - Callback avec le contenu chargé
 * @param {function} onError - Callback en cas d'erreur
 */
async function loadMoreContent(url, onSuccess, onError) {
  const loader = document.getElementById("loader");
  if (loader) loader.style.display = "block";

  try {
    const response = await fetch(url);
    if (!response.ok) throw new Error(`Erreur: ${response.status}`);

    const html = await response.text();
    if (onSuccess) onSuccess(html);
  } catch (error) {
    console.error("Erreur loadMoreContent:", error);
    if (onError) onError(error);
  } finally {
    if (loader) loader.style.display = "none";
  }
}

/**
 * Soumet un formulaire via AJAX
 * @param {HTMLFormElement} form - Le formulaire à soumettre
 * @param {function} onSuccess - Callback en cas de succès
 * @param {function} onError - Callback en cas d'erreur
 */
async function submitFormAjax(form, onSuccess, onError) {
  const formData = new FormData(form);
  const data = Object.fromEntries(formData.entries());

  try {
    const response = await fetch(form.action, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    if (!response.ok) throw new Error(`Erreur: ${response.status}`);

    const result = await response.json();
    if (onSuccess) onSuccess(result);
  } catch (error) {
    console.error("Erreur submitFormAjax:", error);
    if (onError) onError(error);
  }
}

/**
 * Affiche un message toast
 * @param {string} message - Le message à afficher
 * @param {string} type - Type de message (success, error, info, warning)
 */
function showToast(message, type = "info") {
  const toast = document.createElement("div");
  toast.className = `toast-notification toast-${type}`;
  toast.textContent = message;

  document.body.appendChild(toast);

  // Animation d'apparition
  setTimeout(() => toast.classList.add("show"), 100);

  // Disparition après 3 secondes
  setTimeout(() => {
    toast.classList.remove("show");
    setTimeout(() => toast.remove(), 300);
  }, 3000);
}

/**
 * Initialise les boutons de favori AJAX
 */
function initFavoriteButtons() {
  document.querySelectorAll(".btn-favorite").forEach((button) => {
    button.addEventListener("click", function (e) {
      e.preventDefault();
      const itemId = this.dataset.id;
      const itemType = this.dataset.type;
      const isFavorite = this.classList.contains("favorited");

      if (isFavorite) {
        removeFavorite(
          itemId,
          () => {
            this.classList.remove("favorited");
            this.innerHTML = '<i class="far fa-heart"></i>';
            showToast("Retiré des favoris", "success");
          },
          () => showToast("Erreur lors de la suppression", "error"),
        );
      } else {
        addFavorite(
          itemId,
          itemType,
          () => {
            this.classList.add("favorited");
            this.innerHTML = '<i class="fas fa-heart"></i>';
            showToast("Ajouté aux favoris", "success");
          },
          () => showToast("Erreur lors de l'ajout", "error"),
        );
      }
    });
  });
}

// Initialisation au chargement de la page
document.addEventListener("DOMContentLoaded", function () {
  initFavoriteButtons();
});
