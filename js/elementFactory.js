class PostBody {
    postBody = document.createElement("div");


    constructor(name, datetime, text, countLikes, avatarPath, ownLike, ownPost) {

        this.postBody.classList.add("post-body");

        this.postBody.innerHTML = `
        <div class="person-info">
                <img src="${avatarPath}" alt="" width="40">
                <div class="post-info">
                        <p class="person-info__name">${name}</p>
                        <p class="created-time">${datetime}</p>
                </div>
        </div>
        <p class="post-content">${text}</p>`;

        let postActivity = document.createElement("div");
        postActivity.classList.add("post-activity");

        // like button
        let b1 = document.createElement("button");
        b1.classList.add("like");

        let i1 = document.createElement("i");
        i1.classList.add("far", "fa-heart");
        if (ownLike) i1.classList.add("active-like");

        b1.addEventListener("click", e => {
            let target = e.currentTarget;

            let post = target.closest(".post");
            let postId = post.dataset.postId;

            let formData = new FormData();
            formData.append("postId", postId);

            if (i1.classList.contains("active-like")) {
                i1.classList.remove("active-like");

                fetch("../php/likes/removeLike.php", {
                    method: "POST",
                    body: formData
                });
                target.nextSibling.textContent--;

            } else {
                i1.classList.add("active-like");

                fetch("../php/likes/addLike.php", {
                    method: "POST",
                    body: formData
                });
                target.nextSibling.textContent++;
            }
        })

        let likes = document.createElement("span");
        likes.classList.add("count-like");
        likes.textContent = countLikes;

        b1.append(i1);

        // comment button
        let b2 = document.createElement("button");
        b2.classList.add("comment-button");

        b2.addEventListener("click", e => {
            let target = e.currentTarget;

            let post = target.closest(".post");
            let postId = post.dataset.postId;

            let comcon = post.childNodes[1];

            let formData = new FormData();
            formData.append("postId", postId);

            if (comcon.style.display === "none") {

                fetch("../php/getComments.php", {
                        method: "POST",
                        body: formData
                    })
                    .then(response => {
                        return response.text();
                    })
                    .then(text => {
                        JSON.parse(text).forEach(obj => {
                            let com = new Commento(obj.avatar_path, obj.fullName, obj.createdTime, obj.content, obj.commentId).render();
                            comcon.prepend(com);
                        });
                    })
                    .catch(err => {
                        console.error(err);
                    });

                comcon.style.display = "block";

            } else if (comcon.style.display == "block") {
                comcon.style.display = "none";

                let form = comcon.lastChild;

                comcon.innerHTML = "";
                comcon.append(form);
            }
        });

        let i2 = document.createElement("i");
        i2.classList.add("far", "fa-comments");

        b2.append(i2);

        // delete button 

        let b3 = document.createElement("button");
        b3.classList.add("close-button");

        let i3 = document.createElement("i");
        i3.classList.add("fas", "fa-trash-alt");

        b3.addEventListener("click", e => {
            let target = e.currentTarget;

            let post = target.closest(".post");
            let postId = post.dataset.postId;

            let formData = new FormData();
            formData.append("postId", postId);

            fetch("../php/removePost.php", {
                method: "POST",
                body: formData
            });
            post.remove();
        })

        b3.append(i3);

        postActivity.append(b1, likes, b2);
        if (ownPost) postActivity.appendChild(b3);
        this.postBody.append(postActivity);
    }

    render() {
        return this.postBody;
    }
}

class Commento {
    comment = document.createElement("div");

    constructor(avatarPath, name, datetime, text, commentId) {
        this.comment.classList.add("comment");
        this.comment.dataset.commentId = commentId;

        this.comment.innerHTML = `
        <div class="person-info">
        <div>
            <img src="${avatarPath}" alt="" width="40">
        </div>
        <div class="post-info">
            <p class="person-info__name">${name}</p>
            <p class="created-time">${datetime}</p>
        </div>
    </div>
    <p class="comment-body">${text}</p>
        `
    }

    render() {
        return this.comment;
    }
}

class Post {

    static createComContainer() {
        let commentsContaiter = document.createElement("div");
        commentsContaiter.classList.add("comments-container");
        commentsContaiter.style.display = "none";

        let form = document.createElement("form");
        form.classList.add("comment-input");

        let textarea = document.createElement("textarea");
        textarea.setAttribute("placeholder", "Прокомментировать");
        textarea.setAttribute("maxlenght", "150");

        let input = document.createElement("input");
        input.setAttribute("type", "button");
        input.setAttribute("value", "Отправить");

        input.addEventListener("click", e => {
            let target = e.target;

            let postId = target.closest(".post").dataset.postId;
            let comcon = target.closest(".comments-container");
            let textarea = target.previousSibling;

            let formData = new FormData();
            formData.append("text", textarea.value);
            formData.append("postId", postId);


            if (textarea.value === "") return;

            fetch("../php/addComment.php", {
                    method: "POST",
                    body: formData
                })
                .then(response => {
                    return response.text();
                })
                .then(comment => {
                    let obj = JSON.parse(comment);
                    let com = new Commento(obj.avatar, obj.fullName, obj.createdTime, obj.content, obj.commentId).render();

                    comcon.prepend(com);
                })
                .catch(err => {
                    console.error(err);
                });
            textarea.value = "";
        })

        form.append(textarea, input);
        commentsContaiter.append(form);

        return commentsContaiter;
    }
    static createPost(postBody, postId) {
        let post = document.createElement("div");
        post.classList.add("post");
        post.dataset.postId = postId;

        post.append(postBody);
        post.append(Post.createComContainer());

        return post
    }

    static addComment(postId, comment) {
        let post = document.querySelector(`div[data-post-id="${postId}]"`);
        let commentsBlock = post.childNodes[1];
        console.log(commentsBlock);
        commentsBlock.prepend(comment);
    }

}