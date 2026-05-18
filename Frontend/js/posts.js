class PostsPage {

    // =======================
    // INIT
    // =======================
    static init() {

        this.applyRoleTheme();

        this.handleCreatePostButton();

        this.handleAdminPanelButton();

        this.setupSearch();

        this.loadAnnouncements();

        this.loadPosts();

    }



    // =======================
    // ROLE THEME
    // =======================
    static applyRoleTheme() {

        const user =
            Auth.getUser();


        // VISITOR
        if (!user) {

            document.body.classList.add(
                "visitor-theme"
            );

            return;

        }


        // ADMIN
        if (user.role === "admin") {

            document.body.classList.add(
                "admin-theme"
            );

        }

        // EDITOR
        else {

            document.body.classList.add(
                "editor-theme"
            );

        }

    }



    // =======================
    // CREATE POST BUTTON
    // =======================
    static handleCreatePostButton() {

        const button =
            document.getElementById(
                "createPostBtn"
            );


        if (!button) {
            return;
        }


        const user =
            Auth.getUser();


        // visitor
        if (!user) {

            button.style.display =
                "none";

            return;

        }


        // admin NON crea post
        if (user.role === "admin") {

            button.style.display =
                "none";

            return;

        }


        // editor
        button.onclick = () => {

            window.location.href =
                "/html/create-post.html";

        };

    }



    // =======================
    // ADMIN PANEL BUTTON
    // =======================
    static handleAdminPanelButton() {

        const button =
            document.getElementById(
                "adminPanelBtn"
            );


        if (!button) {
            return;
        }


        const user =
            Auth.getUser();


        if (

            user &&

            user.role === "admin"

        ) {

            button.style.display =
                "inline-block";

        }

        else {

            button.style.display =
                "none";

        }

    }




    // =======================
    // SEARCH
    // =======================
    static setupSearch() {

        const input =
            document.getElementById(
                "search"
            );


        if (!input) {
            return;
        }


        input.addEventListener(

            "input",

            () => {

                this.loadPosts();

            }

        );

    }



    // =======================
    // LOAD POSTS
    // =======================
    static loadPosts() {

        const search =
            document
                .getElementById("search")
                ?.value || "";


        Api.getPosts(search)

        .then(res => res.json())

        .then(data => {

            let html = "";

            const user =
                Auth.getUser();



            data.forEach(post => {

                html += `

                    <div class="post">

                        <h2 class="post-title">
                        ${this.escapeHtml(post.title)}
                        </h2>

                            <div class="post-content">
                                ${this.escapeHtml(post.content)}
                            </div>

                            <div class="post-author">

                                ${post.role === "admin"

                                    ? '👑 ADMIN'

                                    : '✍️ EDITOR'

                                }

                                ${post.name}

                            </div>

                    <div id="comments-${post.id}"></div>

                `;



                // VISITOR
                if (!user) {

                    html += `
                        <p>
                            🔒 Fai login per interagire
                        </p>
                    `;
                }



                // COMMENT BOX
                if (user) {

                    html += `

                        <input
                            id="comment-${post.id}"
                            placeholder="Scrivi commento"
                        >

                        <button
                            onclick="PostsPage.addComment(${post.id})"
                        >
                            Invia
                        </button>

                    `;
                }



                // OWNER + ADMIN
                if (

                    user &&

                    (

                        post.user_id == user.id ||

                        user.role === "admin"

                    )

                ) {

                    html += `

                        <button
                            onclick="PostsPage.deletePost(${post.id})"
                        >
                            🗑
                        </button>

                        <button
                            onclick="PostsPage.editPost(
                                ${post.id},
                                \`${post.title}\`,
                                \`${post.content}\`
                            )"
                        >
                            ✏️
                        </button>

                    `;
                }



                html += `
                    </div>
                `;

            });



            document
                .getElementById("posts")
                .innerHTML = html;



            data.forEach(post => {

                this.loadComments(
                    post.id
                );

            });

        })

        .catch(console.error);

    }


    // =======================
    // LOAD ANNOUNCEMENTS
    // =======================
    static loadAnnouncements() {

        const box =
            document.getElementById(
                "announcementBox"
            );


        if (!box) {
            return;
        }


        Api.getAnnouncements()

        .then(res => res.json())

        .then(data => {

            if (!data.length) {

                box.innerHTML = "";

                return;
            }


            let html = "";


            data.forEach(item => {

                html += `

                    <div class="announcement">

                        <h3>
                            📢 Annuncio Admin
                        </h3>

                        <p>
                            ${this.escapeHtml(
                                item.message
                            )}
                        </p>

                    </div>

                `;

            });


            box.innerHTML = html;

        })

        .catch(console.error);

    }



    // =======================
    // DELETE POST
    // =======================
    static deletePost(id) {

        Api.deletePost(id)

        .then(res => res.json())

        .then(() => {

            this.loadPosts();

        })

        .catch(console.error);

    }



    // =======================
    // EDIT POST
    // =======================
    static editPost(
        id,
        oldTitle,
        oldContent
    ) {

        const title =
            prompt(
                "Titolo:",
                oldTitle
            );


        const content =
            prompt(
                "Contenuto:",
                oldContent
            );


        if (!title || !content) {
            return;
        }



        Api.updatePost(

            id,

            {
                title,
                content
            }

        )

        .then(res => res.json())

        .then(() => {

            this.loadPosts();

        })

        .catch(console.error);

    }



    // =======================
    // LOAD COMMENTS
    // =======================
    static loadComments(post_id) {

        Api.getComments(post_id)

        .then(res => res.json())

        .then(data => {

            let html = "";

            const user =
                Auth.getUser();



            data.forEach(c => {

                html += `

                    <div class="comment-item">

                        <div class="comment-author">

                            ${c.role === "admin"

                                ? '👑 ADMIN'

                                : '✍️ EDITOR'

                            }

                            ${c.name || "Unknown"}

                        </div>

                        <div class="comment-content">

                            ${this.escapeHtml(c.content)}

                        </div>

                `;



                if (

                    user &&

                    (

                        c.user_id == user.id ||

                        user.role === "admin"

                    )

                ) {

                    html += `

                        <button
                            onclick="PostsPage.deleteComment(${c.id})"
                        >
                            🗑
                        </button>

                        <button
                            onclick="PostsPage.editComment(
                                ${c.id},
                                \`${c.content}\`
                            )"
                        >
                            ✏️
                        </button>

                    `;
                }



                html += `
                    </p>
                `;

            });



            document
                .getElementById(
                    `comments-${post_id}`
                )
                .innerHTML = html;

        })

        .catch(console.error);

    }



    // =======================
    // ADD COMMENT
    // =======================
    static addComment(post_id) {

        const input =
            document.getElementById(
                `comment-${post_id}`
            );


        if (!input) {
            return;
        }


        const content =
            input.value.trim();


        if (!content) {

            alert(
                "Scrivi un commento!"
            );

            return;

        }



        Api.addComment({

            content,

            post_id

        })

        .then(res => res.json())

        .then(data => {

            if (data.error) {

                alert(
                    data.error
                );

                return;

            }


            input.value = "";


            this.loadComments(
                post_id
            );

        })

        .catch(console.error);

    }



    // =======================
    // DELETE COMMENT
    // =======================
    static deleteComment(id) {

        Api.deleteComment(id)

        .then(res => res.json())

        .then(() => {

            this.loadPosts();

        })

        .catch(console.error);

    }



    // =======================
    // EDIT COMMENT
    // =======================
    static editComment(
        id,
        oldContent
    ) {

        const content =
            prompt(
                "Modifica commento:",
                oldContent
            );


        if (!content) {
            return;
        }



        Api.updateComment(

            id,

            {
                content
            }

        )

        .then(res => res.json())

        .then(() => {

            this.loadPosts();

        })

        .catch(console.error);

    }



    // =======================
    // XSS PROTECTION
    // =======================
    static escapeHtml(text) {

        if (!text) {
            return "";
        }


        return text

            .replace(
                /&/g,
                "&amp;"
            )

            .replace(
                /</g,
                "&lt;"
            )

            .replace(
                />/g,
                "&gt;"
            );

    }

}



// START PAGE
PostsPage.init();