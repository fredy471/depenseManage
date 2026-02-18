import { saveBuckets, getBuckets } from "./storage.js";
import { renderBucket, openNav, closeNav } from "./ui.js";

/**
 * @param {string} key
 * @param {any} value
 */


const userId = Number(document.body.getAttribute("data-user-id"));
if (!userId) {
    alert("Utilisateur non identifié. Veuillez vous connecter.");
    window.location.href = "login.php";
}

let allBuckets = getBuckets(userId);

const bucketContainer = document.getElementById("bucketContainer");
const submitPanierButton = document.getElementById("submitPanierButton");
const saveExpenseBtn = document.getElementById("saveExpenseBtn");

export function GlobalStats(buckets) {
    const element = document.getElementById("globalstats");
    // je calcule le total des budgets
    const globalBudget = buckets.reduce((sum, b) => sum + (Number(b.budget) || 0), 0);

    //je dois d'abord avoir le total des depenses au niveau de la fonction creerPanier en  parcourant chaque expense et en faisant la somme comme ca je pourrai faire la somme globale des depenses ou je cree la constante dans ui.js qui calcule la somme des depenses dans chaque pannier et je l'apelle ici

    //je calcule le total des depenses

    const globalSpent = buckets.reduce((sum, b) => {
        const bucketSpent = b.expenses.reduce((expenseSum, exp) => expenseSum + (Number(exp.montant) || 0), 0);
        return sum + bucketSpent;
    }, 0);

    // je calcule le total des reserves ou epargnees



}


export function creerPanier() {
    const bucketNameInput = document.getElementById('bucketName');
    const bucketBudgetInput = document.getElementById('bucketBudget');
    const bucketName = bucketNameInput.value.trim();
    const bucketBudget = parseFloat(bucketBudgetInput.value);

    if (bucketName === '' || isNaN(bucketBudget) || bucketBudget <= 0) {
        alert('Veuillez entrer un nom de projet valide et un budget initial supérieur à 0.');
        return;
    }
    /**
     * @type {{id: number, name: string, budget: number, expenses: Array}}
     */
    const newBucket = {
        id: Date.now(),
        name: bucketName,
        budget: bucketBudget,
        expenses: []
    };

    allBuckets.push(newBucket);
    saveBuckets(userId, allBuckets);
    renderBucket(allBuckets, deleteBuckets, deleteExpense, openAnalytics);
    console.log(allBuckets)
    /* je dois render() le nouveau panier dans l'UI */


    // Réinitialiser les champs du formulaire
    bucketNameInput.value = '';
    bucketBudgetInput.value = '';

    // Fermer le modal
    const modalElement = document.getElementById('creerPanierModal');
    const modalInstance = bootstrap.Modal.getOrCreateInstance(modalElement);
    modalInstance.hide();
}

export function deleteBuckets(bucketId) {
    allBuckets = allBuckets.filter(bucket => bucket.id !== bucketId);
    saveBuckets(userId, allBuckets);
    renderBucket(allBuckets, deleteBuckets, deleteExpense, openAnalytics);
}

// Afficher les paniers par défaut au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    if (bucketContainer) {
        renderBucket(allBuckets, deleteBuckets, deleteExpense, openAnalytics);
    }
});

//Afficher les paniers cree
if (submitPanierButton) {
    submitPanierButton.addEventListener('click', creerPanier);
}

export function addExpense() {
    const bucketId = Number(document.getElementById("currentBucketId").value);
    const categorie = document.getElementById("expenseCategory").value;
    const amount = parseFloat(document.getElementById("expenseAmount").value);

    if (isNaN(amount) || amount <= 0) {
        alert("Montant invalide");
        return;
    }

    const bucket = allBuckets.find(b => b.id === bucketId);

    if (!bucket) {
        console.log("aucun element trouve");
        alert('element inxesitant');
        return;
    }

    const totalExpenses = bucket.expenses.reduce((sum, exp) => sum + exp.montant, 0);
    const remainingBudget = bucket.budget - totalExpenses;

    if (amount > remainingBudget) {
        alert(`Le montant saisi (${amount} F CFA) dépasse le budget restant du panier (${remainingBudget} F CFA).`);
        return;
    }

    const newExpense = {
        id: Date.now(),
        category: categorie,
        montant: amount
    };

    bucket.expenses.push(newExpense);
    saveBuckets(userId, allBuckets);
    renderBucket(allBuckets, deleteBuckets, deleteExpense, openAnalytics);

    // Réinitialiser les champs du formulaire
    document.getElementById("expenseCategory").value = '';
    document.getElementById("expenseAmount").value = '';

    bootstrap.Modal.getInstance(document.getElementById('addExpenseModal')).hide();
}
/**
 * 
 * @param {number} bucketId 
 * @param {number} expenseId 
 * @returns 
 */

export function deleteExpense(bucketId, expenseId) {
    const bucket = allBuckets.find(b => b.id == bucketId);
    if (!bucket) return;

    try {
        // Supprimer la dépense
        bucket.expenses = bucket.expenses.filter(exp => exp.id !== expenseId);

        // Sauvegarder les modifications
        saveBuckets(userId, allBuckets);

        // Re-render les buckets
        renderBucket(allBuckets, deleteBuckets, deleteExpense, openAnalytics);
    } catch (e) {
        alert("Une erreur est survenue lors de la suppression de la dépense.");
        console.error(e);
    }
}

// utiliser la regle du 50,30,20 pour calculer ou proposer une repatititon des depenses, epargns et loisirs pour un e bonne gestion
export function calculateBudgetDistribution(bucket) {
    const totalExpenses = bucket.expenses.reduce((sum, exp) => sum + exp.montant, 0);
    const remainingBudget = bucket.budget - totalExpenses;
    const needs = bucket.budget * 0.5; // 50% pour les besoins essentiels
    const wants = bucket.budget * 0.3; // 30% pour les loisirs
    const savings = bucket.budget * 0.2; // 20% pour l'épargne

    return {
        needs: needs,
        wants: wants,
        savings: savings,
        remainingBudget: remainingBudget
    };
}


function openAnalytics(bucketId) {
    const bucket = allBuckets.find(b => b.id === bucketId);
    if (!bucket) {
        alert('Panier introuvable.');
        return;
    }

    const totalExpenses = bucket.expenses.reduce((sum, exp) => sum + exp.montant, 0);
    const budget = bucket.budget;
    const percentSpent = budget > 0 ? (totalExpenses / budget) * 100 : 0;

    const categoryStats = bucket.expenses.reduce((acc, exp) => {
        if (!acc[exp.category]) {
            acc[exp.category] = { count: 0, total: 0 };
        }
        acc[exp.category].count += 1;
        acc[exp.category].total += exp.montant;
        return acc;
    }, {});

    const categoryEntries = Object.entries(categoryStats);
    categoryEntries.sort((a, b) => b[1].count - a[1].count);
    const topCategories = categoryEntries.slice(0, 3);

    const topCategoriesContainer = document.getElementById('analyticsTopCategories');
    const breakdownContainer = document.getElementById('analyticsCategoryBreakdown');
    const ruleSummary = document.getElementById('analyticsRuleSummary');

    topCategoriesContainer.innerHTML = '';
    breakdownContainer.innerHTML = '';

    if (topCategories.length === 0) {
        topCategoriesContainer.textContent = 'Aucune depense enregistree.';
    } else {
        topCategories.forEach(([category, stats]) => {
            const percent = budget > 0 ? (stats.total / budget) * 100 : 0;
            const line = document.createElement('div');
            line.className = 'analytics-item';
            line.textContent = `${category} (${stats.count}) - ${percent.toFixed(1)}% du budget`;
            topCategoriesContainer.appendChild(line);
        });
    }

    if (categoryEntries.length === 0) {
        breakdownContainer.textContent = 'Aucune depense enregistree.';
    } else {
        categoryEntries.forEach(([category, stats]) => {
            const percent = budget > 0 ? (stats.total / budget) * 100 : 0;
            const line = document.createElement('div');
            line.className = 'analytics-item';
            line.textContent = `${category} - ${stats.total} (${percent.toFixed(1)}%)`;
            breakdownContainer.appendChild(line);
        });
    }

    const distribution = calculateBudgetDistribution(bucket);
    ruleSummary.innerHTML = `Budget: ${budget}. Depense: ${totalExpenses} (${percentSpent.toFixed(1)}%).<br>`
        + `<span class="analytics-highlight">Ideal 50/30/20</span>: `
        + `Besoins ${distribution.needs}, Loisirs ${distribution.wants}, `
        + `Epargne ${distribution.savings}. Restant ${distribution.remainingBudget}.`;

    const modal = new bootstrap.Modal(document.getElementById('analyticsModal'));
    modal.show();
}

if (saveExpenseBtn) {
    saveExpenseBtn.addEventListener("click", addExpense);
}

const openNavButton = document.getElementById("openNav");
if (openNavButton) {
    openNavButton.addEventListener("click", openNav);
}

const closeNavButton = document.getElementById("closeNav");
if (closeNavButton) {
    closeNavButton.addEventListener("click", closeNav);
}

document.querySelectorAll(".logout-link").forEach((link) => {
    link.addEventListener("click", async (e) => {
        e.preventDefault();

        const ok = window.confirm("Voulez-vous vraiment vous déconnecter ?");
        if (!ok) return;

        await fetch("logout.php", {
            method: "POST",
            credentials: "same-origin"
        });
        window.location.href = "login.php";
    });
});

