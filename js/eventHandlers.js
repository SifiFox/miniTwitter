let createPostButton = document.querySelector("#createPostButton");

createPostButton.addEventListener("click", e => {
    let twitInput = document.getElementById("twitInput");

    if (twitInput.value === "") return;

    let formData = new FormData();
    formData.append("text", twitInput.value);

    fetch("../php/addPost.php", {
            method: "POST",
            body: formData
        })
        .then(response => {
            return response.text();
        })
        .then(post => {
            addPost(JSON.parse(post));
        })
        .catch(err => {
            console.error(err);
        });
    twitInput.value = "";
});

function addPost(obj) {
    const tape = document.querySelector(".tape");

    let postBody = new PostBody(obj.fullName, obj.createdTime, obj.content, obj.countLike,
        obj.avatar_path, obj.ownLike, obj.ownPost).render();

    let post = Post.createPost(postBody, obj.postId);
    tape.prepend(post);
}

function subscribe() {
    
}