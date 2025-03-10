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

function rechercherEmprunteur(livreId) {
    fetch(`public/controllers/emprunt_controller.php?livre_id=${livreId}`)
        .then(response => response.json())
        .then(data => {
            alert(data.message || `Emprunteur : ${data.user_id}`);
        })
        .catch(error => console.error("Erreur :", error));
}
