const postForm = document.getElementById("post-form");
const postList = document.getElementById("post-list");
const postCount = document.getElementById("post-count");
const postIdInput = document.getElementById("post-id");
const formTitle = document.getElementById("form-title");
const saveButton = document.getElementById("save-button");
const cancelEditButton = document.getElementById("cancel-edit");
const message = document.getElementById("message");
const api = "backend/api/posts.php";

function showMessage(text, isError = false) {
    message.textContent = text;
    message.className = isError
        ? "rounded-lg bg-red-100 p-3 text-sm font-medium text-red-800"
        : "rounded-lg bg-green-100 p-3 text-sm font-medium text-green-800";
}

async function sendRequest(method, values = null) {
    const options = { method };

    if (values !== null) {
        options.headers = {
            "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8"
        };
        options.body = new URLSearchParams(values).toString();
    }

    const response = await fetch(api, options);
    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || "La demande n'a pas abouti.");
    }

    return data;
}

function createPostCard(post) {
    const card = document.createElement("article");
    card.className = "rounded-xl border border-slate-200 bg-white p-5 shadow-sm";

    const header = document.createElement("div");
    header.className = "flex items-start justify-between gap-4";

    const authorBlock = document.createElement("div");
    authorBlock.className = "flex min-w-0 items-center gap-3";

    const avatar = document.createElement("div");
    avatar.className = "flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800";
    avatar.textContent = post.author.trim().slice(0, 2).toUpperCase();

    const authorInfo = document.createElement("div");
    authorInfo.className = "min-w-0";

    const author = document.createElement("h3");
    author.className = "truncate font-bold";
    author.textContent = post.author;

    const role = document.createElement("p");
    role.className = "truncate text-sm text-slate-500";
    role.textContent = post.role;

    const date = document.createElement("p");
    date.className = "mt-1 text-xs text-slate-400";
    date.textContent = new Date(post.createdAt).toLocaleString("fr-FR");

    authorInfo.append(author, role, date);
    authorBlock.append(avatar, authorInfo);

    const actions = document.createElement("div");
    actions.className = "flex shrink-0 gap-2";

    const editButton = document.createElement("button");
    editButton.type = "button";
    editButton.dataset.action = "edit";
    editButton.dataset.id = post.id;
    editButton.className = "rounded-md px-2 py-1 text-sm font-semibold text-primary-600 hover:bg-primary-50";
    editButton.textContent = "Modifier";

    const deleteButton = document.createElement("button");
    deleteButton.type = "button";
    deleteButton.dataset.action = "delete";
    deleteButton.dataset.id = post.id;
    deleteButton.className = "rounded-md px-2 py-1 text-sm font-semibold text-red-600 hover:bg-red-50";
    deleteButton.textContent = "Supprimer";

    actions.append(editButton, deleteButton);
    header.append(authorBlock, actions);

    const content = document.createElement("p");
    content.className = "mt-5 whitespace-pre-wrap leading-7 text-slate-700";
    content.textContent = post.content;

    card.append(header, content);
    return card;
}

async function showPosts() {
    try {
        const posts = await sendRequest("GET");
        postList.replaceChildren();
        postCount.textContent = posts.length;

        if (posts.length === 0) {
            const emptyMessage = document.createElement("p");
            emptyMessage.className = "rounded-xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500";
            emptyMessage.textContent = "Aucune publication pour le moment. Soyez le premier à partager une actualité.";
            postList.appendChild(emptyMessage);
            return;
        }

        posts.forEach(post => postList.appendChild(createPostCard(post)));
    } catch (error) {
        showMessage(error.message, true);
    }
}

function resetForm() {
    postForm.reset();
    postIdInput.value = "";
    formTitle.textContent = "Créer une publication";
    saveButton.textContent = "Publier";
    cancelEditButton.classList.add("hidden");
}

postForm.addEventListener("submit", async event => {
    event.preventDefault();
    saveButton.disabled = true;

    const values = Object.fromEntries(new FormData(postForm).entries());
    const isEditing = postIdInput.value !== "";

    try {
        const result = await sendRequest(isEditing ? "PUT" : "POST", values);
        showMessage(result.message);
        resetForm();
        await showPosts();
    } catch (error) {
        showMessage(error.message, true);
    } finally {
        saveButton.disabled = false;
    }
});

postList.addEventListener("click", async event => {
    const button = event.target.closest("button[data-action]");

    if (!button) {
        return;
    }

    const postId = button.dataset.id;

    if (button.dataset.action === "edit") {
        try {
            const posts = await sendRequest("GET");
            const post = posts.find(item => String(item.id) === postId);

            if (!post) {
                throw new Error("Cette publication n'existe plus.");
            }

            postIdInput.value = post.id;
            postForm.elements.author.value = post.author;
            postForm.elements.role.value = post.role;
            postForm.elements.content.value = post.content;
            formTitle.textContent = "Modifier la publication";
            saveButton.textContent = "Enregistrer les modifications";
            cancelEditButton.classList.remove("hidden");
            postForm.scrollIntoView({ behavior: "smooth", block: "start" });
        } catch (error) {
            showMessage(error.message, true);
        }
    }

    if (button.dataset.action === "delete") {
        if (!window.confirm("Voulez-vous vraiment supprimer cette publication ?")) {
            return;
        }

        try {
            const result = await sendRequest("DELETE", { id: postId });
            showMessage(result.message);
            await showPosts();
        } catch (error) {
            showMessage(error.message, true);
        }
    }
});

cancelEditButton.addEventListener("click", resetForm);

showPosts();
