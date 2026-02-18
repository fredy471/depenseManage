export function openNav() {
    const elm = document.querySelector('.menulink-r');
    if (elm) {
        elm.style.overflow = "hidden";
        elm.style.width = "250px";
    } else {
        console.error("L'élément avec la classe '.menulink-r' est introuvable.");
    }
}

export function closeNav() {
    const elm = document.querySelector('.menulink-r');
    if (elm) {
        elm.style.overflow = "auto";
        elm.style.width = "0";
    } else {
        console.error("L'élément avec la classe '.menulink-r' est introuvable.");
    }
}

/**
 * @param {string} key
 * @param {any} value
 */
export function renderBucket(buckets, onDelete, onDeleteExpense, onViewAnalytics) {
    const bucketContainer = document.getElementById('bucketContainer');
    const bucketTemplate = document.getElementById('bucketTemplate');

    // Vider le conteneur avant de rendre les paniers
    bucketContainer.innerHTML = '';

    // Vérifier si le tableau est vide
    if (buckets.length === 0) {
        const emptyMessage = document.createElement('p');
        emptyMessage.textContent = "Aucun panier n'a encore été créé.";
        emptyMessage.style.textAlign = "center";
        emptyMessage.style.color = "#888"; // Couleur grise pour le texte
        bucketContainer.appendChild(emptyMessage);
        return;
    }

    buckets.forEach(bucket => {

        const clone = bucketTemplate.content.cloneNode(true);
        const addExpenseBtn = clone.querySelector(".add-expense-btn");
        clone.querySelector('.bucket-name').textContent = bucket.name;
        clone.querySelector('.bucket-budget').textContent = `Budget: ${bucket.budget}`;
        const total = bucket.expenses.reduce((sum, exp) => sum + exp.montant, 0);
        const remaining = bucket.budget - total;
        const percent = (total / bucket.budget) * 100;
        clone.querySelector(".bucket-total").textContent = total;
        clone.querySelector(".bucket-remaining").textContent = `${remaining}`;
        clone.querySelector(".percent-text").textContent = `${percent.toFixed(1)}%`;
        clone.querySelector(".progress-bar").style.width = `${percent}%`;


        //je veux rendre le button insdisponible si le budget est depasse
            if (remaining <= 0) {
                addExpenseBtn.disabled = true;
                addExpenseBtn.textContent = "Budget Atteint";
                addExpenseBtn.classList.remove("btn-outline-primary");
                addExpenseBtn.classList.add("btn-danger");
            } 

        const deleteButton = clone.querySelector('.delete-bucket-btn');
        deleteButton.addEventListener('click', () => {
            onDelete(bucket.id);
        })

        addExpenseBtn.addEventListener("click", () => {
            if (addExpenseBtn) {
                document.getElementById("currentBucketId").value = bucket.id;
                const modal = new bootstrap.Modal(document.getElementById('addExpenseModal'));
                modal.show();
            }
        });

        const analyticsLink = clone.querySelector('.view-analytics-link');
        if (analyticsLink && onViewAnalytics) {
            analyticsLink.addEventListener('click', (e) => {
                e.preventDefault();
                onViewAnalytics(bucket.id);
            });
        }

        if (!addExpenseBtn) {
            alert("Bouton d'ajout de dépense introuvable dans le template.");
            return;
        }


        const expenseList = clone.querySelector(".expense-list");
        const expenseTemplate = document.getElementById("expenseTemplate");

        bucket.expenses.forEach(exp => {

            // if (bucket.expenses.length === 0) {
            //     const emptyMessage = document.createElement('p');
            //     emptyMessage.textContent = "Aucune dépense n'a encore été ajoutée à ce panier.";
            //     emptyMessage.style.textAlign = "center";
            //     emptyMessage.style.color = "#888"; // Couleur grise pour le texte
            //     expenseList.appendChild(emptyMessage);
            // }
            const expenseClone = expenseTemplate.content.cloneNode(true);
            expenseClone.querySelector('.expense-category').textContent = exp.category;
            expenseClone.querySelector('.expense-amount').textContent = exp.montant;

           

            expenseClone.querySelector(".delete-expense-btn").addEventListener('click', () => {
                onDeleteExpense(bucket.id, exp.id); // tu créeras cette fonction dans app.js
            });

            expenseList.appendChild(expenseClone);
        });

        bucketContainer.appendChild(clone);
    })
}


