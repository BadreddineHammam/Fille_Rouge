const form = document.getElementById("categoryForm");
const button = document.getElementById("botton");
const spinner = document.getElementById("spinner");
const message = document.getElementById("message");
const result = document.getElementById("categoryList");

function showMessage(text, isError) {
    message.textContent = text;
    message.className = isError ? "bg-red-100 p-4" : "bg-green-100 p-4";

    setTimeout(() => {
        message.textContent = "";
        message.className = "";
    }, 2000);
}

function show() {
    fetch("backend/api/api.php", { method: "GET" })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Une erreur est survenue lors du chargement des catégories.");
            }

            return response.json();
        })
        .then((data) => {
            result.replaceChildren();

            data.forEach((element) => {
                const row = document.createElement("tr");
                const cell = document.createElement("td");
                cell.textContent = element.name;
                cell.className = "p-4";
                row.appendChild(cell);
                result.appendChild(row);
            });
        })
        .catch((error) => showMessage(error.message, true));
}

form.addEventListener("submit", async (event) => {
    event.preventDefault();

    const categoryName = document.getElementById("categoryName").value.trim();
    if (!categoryName) {
        showMessage("Veuillez écrire le nom d'une catégorie.", true);
        return;
    }

    button.disabled = true;
    spinner.classList.remove("hidden");

    try {
        const response = await fetch("backend/api/api.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ name: categoryName })
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || "Impossible d'ajouter cette catégorie.");
        }

        form.reset();
        showMessage("Catégorie ajoutée avec succès.", false);
        show();
    } catch (error) {
        showMessage(error.message, true);
    } finally {
        button.disabled = false;
        spinner.classList.add("hidden");
    }
});

show();