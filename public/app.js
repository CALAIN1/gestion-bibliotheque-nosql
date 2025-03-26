// Fonction pour rechercher un livre par auteur
function rechercherLivre() {
    let auteur = document.getElementById("auteur").value;
    fetch(`/livre/recherche/${auteur}`)
        .then(response => response.json())
        .then(data => {
            let resultDiv = document.getElementById("resultats");
            resultDiv.innerHTML = "<h3>Résultats :</h3>";

            if (data.length === 0) {
                resultDiv.innerHTML += "<p>Aucun livre trouvé pour cet auteur.</p>";
                return;
            }

            let ul = document.createElement("ul");
            ul.classList.add("list-group");

            data.forEach(livre => {
                let li = document.createElement("li");
                li.classList.add("list-group-item");
                li.innerHTML = `
                    <strong>${livre.titre}</strong> - ${livre.auteur} 
                    <button class="btn btn-sm btn-info ms-3" onclick="rechercherEmprunteur('${livre._id}')">📌 Voir l’emprunteur</button>
                `;
                ul.appendChild(li);
            });

            resultDiv.appendChild(ul);
        })
        .catch(error => console.error("Erreur :", error));
}

// Gestion de l'ajout de livre
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("ajoutLivreForm");
    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const titre = document.getElementById("titre").value;
            const auteur = document.getElementById("auteur").value;
            const annee = document.getElementById("annee").value;

            const response = await fetch("/livre/ajout", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ titre, auteur, annee }),
            });

            const data = await response.json();

            const messageDiv = document.getElementById("message");
            if (response.ok) {
                messageDiv.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                form.reset();
            } else {
                messageDiv.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
            }

            // Recharger la liste des livres
            chargerListeLivres();
        });
    }
});

// Fonction pour charger la liste de tous les livres
function chargerListeLivres() {
    fetch("/livres")
        .then(response => response.json())
        .then(data => {
            const listeLivresDiv = document.getElementById("listeLivres");
            listeLivresDiv.innerHTML = '';  // Vider la liste avant de la remplir

            if (data.length === 0) {
                listeLivresDiv.innerHTML = "<p>Aucun livre enregistré.</p>";
            } else {
                let ul = document.createElement("ul");
                ul.classList.add("list-group");

                data.forEach(livre => {
                    let li = document.createElement("li");
                    li.classList.add("list-group-item");
                    li.innerHTML = `<strong>${livre.titre}</strong> - ${livre.auteur} (${livre.annee})`;
                    ul.appendChild(li);
                });

                listeLivresDiv.appendChild(ul);
            }
        })
        .catch(error => {
            console.error("Erreur :", error);
            listeLivresDiv.innerHTML = "<p>Impossible de charger les livres.</p>";
        });
}

// Soumission du formulaire d'emprunt
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("empruntForm");
    const messageDiv = document.getElementById("message");
    const listeDiv = document.getElementById("listeEmprunts");

    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const data = {
                titre: document.getElementById("titre").value,
                auteur: document.getElementById("auteur").value,
                emprunteur: document.getElementById("emprunteur").value
            };

            try {
                const response = await fetch("/livre/emprunter", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                messageDiv.innerHTML = response.ok
                    ? `<div class="alert alert-success">${result.message}</div>`
                    : `<div class="alert alert-danger">${result.error}</div>`;

                if (response.ok) {
                    form.reset();
                    afficherEmprunts(); // recharge les emprunts
                }

            } catch (error) {
                messageDiv.innerHTML = `<div class="alert alert-danger">Erreur réseau</div>`;
            }
        });
    }

    // Fonction d'affichage des emprunts
    async function afficherEmprunts() {
        try {
            const response = await fetch("/emprunts");
            const emprunts = await response.json();

            if (Array.isArray(emprunts)) {
                listeDiv.innerHTML = "";
                emprunts.forEach(e => {
                    const div = document.createElement("div");
                    div.className = "card p-2 mb-2";
                    div.innerHTML = `<strong>${e.titre}</strong> par ${e.auteur} — emprunté par <em>${e.emprunteur}</em> le ${new Date(e.date_emprunt.date || e.date_emprunt).toLocaleString("fr-FR")}`;
                    listeDiv.appendChild(div);
                });
            } else {
                listeDiv.innerHTML = `<div class="text-muted">Aucun emprunt enregistré.</div>`;
            }
        } catch (error) {
            listeDiv.innerHTML = `<div class="alert alert-danger">Impossible de charger les emprunts.</div>`;
        }
    }

    // Chargement initial
    if (listeDiv) {
        afficherEmprunts();
    }
});
