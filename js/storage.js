/**
 * Recuperation et sauvegarde des donnees dans le localStorage
 */

/// Je vais stocker les données de chaque utilisateur sous une clé spécifique pour éviter les conflits entre utilisateurs
export function saveBuckets(userId, buckets) {
    localStorage.setItem(`buckets_${userId}`, JSON.stringify(buckets));
}

// Je vais récupérer les données du localStorage en fonction de l'utilisateur connecté
export function getBuckets(userId) {
    const data = localStorage.getItem(`buckets_${userId}`);
    return data ? JSON.parse(data) : [];
}

// Fonction pour supprimer les données d'un utilisateur spécifique. la deconnexion ne supprimera pas les données mais juste redirigera vers la page de login, les données seront supprimées uniquement si l'utilisateur choisit de supprimer son compte ou si on veut faire du nettoyage de données
export function clearBuckets(userId) {
    localStorage.removeItem(`buckets_${userId}`);
}
