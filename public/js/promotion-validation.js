function validatePromotion(formData) {
    const errors = {};
    
    // Validation du nom de la promotion
    if (!formData.promotion) {
        errors.promotion = "Le nom de la promotion est requis";
    } else if (formData.promotion.length < 3) {
        errors.promotion = "Le nom de la promotion doit contenir au moins 3 caractères";
    } else if (formData.promotion.length > 50) {
        errors.promotion = "Le nom de la promotion ne doit pas dépasser 50 caractères";
    }

    // Validation de la date de début
    if (!formData.date_debut) {
        errors.date_debut = "La date de début est requise";
    } else {
        const dateDebut = new Date(formData.date_debut);
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        if (isNaN(dateDebut.getTime())) {
            errors.date_debut = "La date de début n'est pas valide";
        } else if (dateDebut < today) {
            errors.date_debut = "La date de début ne peut pas être dans le passé";
        }
    }

    // Validation de la date de fin
    if (!formData.date_fin) {
        errors.date_fin = "La date de fin est requise";
    } else {
        const dateFin = new Date(formData.date_fin);
        const dateDebut = new Date(formData.date_debut);
        const twoYearsFromNow = new Date();
        twoYearsFromNow.setFullYear(twoYearsFromNow.getFullYear() + 2);

        if (isNaN(dateFin.getTime())) {
            errors.date_fin = "La date de fin n'est pas valide";
        } else if (formData.date_debut && dateFin <= dateDebut) {
            errors.date_fin = "La date de fin doit être postérieure à la date de début";
        } else if (dateFin > twoYearsFromNow) {
            errors.date_fin = "La date de fin ne peut pas être plus de 2 ans dans le futur";
        }
    }

    // Validation du référentiel
    if (!formData.referentiel) {
        errors.referentiel = "Le référentiel est requis";
    }

    // Validation du statut
    if (formData.statut && !['active', 'inactive'].includes(formData.statut)) {
        errors.statut = "Le statut doit être 'active' ou 'inactive'";
    }

    return errors;
}

// Fonction pour afficher les erreurs dans le formulaire
function displayErrors(errors) {
    // Supprimer les messages d'erreur précédents
    document.querySelectorAll('.error-message').forEach(el => el.remove());
    
    // Afficher les nouvelles erreurs
    for (const [field, message] of Object.entries(errors)) {
        const input = document.querySelector(`[name="${field}"]`);
        if (input) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message text-danger';
            errorDiv.textContent = message;
            input.parentNode.appendChild(errorDiv);
        }
    }
}

// Fonction pour valider le formulaire avant soumission
function validateForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    const errors = validatePromotion(data);
    
    if (Object.keys(errors).length === 0) {
        form.submit();
    } else {
        displayErrors(errors);
    }
}

// Ajouter l'écouteur d'événement au formulaire
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', validateForm);
    }
}); 