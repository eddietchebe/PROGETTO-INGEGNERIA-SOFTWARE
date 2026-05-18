class AdminUsersPage {

    static init() {

        const user =
            Auth.getUser();


        // sicurezza frontend
        if (

            !user ||

            user.role !== "admin"

        ) {

            alert(
                "Accesso negato"
            );

            window.location.href =
                "/html/posts.html";

            return;

        }

        this.loadAnnouncements();
        this.loadUsers();

    }



    static loadUsers() {

        Api.getUsers()

        .then(res => res.json())

        .then(data => {

            let html = "";


            data.forEach(user => {

                html += `

                    <div class="post">

                        <h3>

                            ${user.name}

                        </h3>

                        <p>

                            ${user.email}

                        </p>

                        <small>

                            ${user.role === "admin"

                                ? "👑 ADMIN"

                                : "✍️ EDITOR"

                            }

                        </small>

                        <br><br>

                        <button
                            onclick="AdminUsersPage.deleteUser(${user.id})"
                        >
                            🗑 Elimina
                        </button>

                    </div>

                `;

            });


            document
                .getElementById("users")
                .innerHTML = html;

        })

        .catch(console.error);

    }



    static loadAnnouncements() {

        const box =
            document.getElementById(
                "announcementList"
            );


        if (!box) {
            return;
        }


        Api.getAnnouncements()

        .then(res => res.json())

        .then(data => {

            let html = "";


            data.forEach(item => {

                html += `

                    <div class="post">

                        <h3>
                            📢 Annuncio
                        </h3>

                        <p>
                            ${item.message}
                        </p>

                        <button
                            onclick="AdminUsersPage.editAnnouncement(
                                ${item.id},
                                \`${item.message}\`
                            )"
                        >
                            ✏️
                        </button>

                        <button
                            onclick="AdminUsersPage.deleteAnnouncement(
                                ${item.id}
                            )"
                        >
                            🗑
                        </button>

                    </div>

                `;

            });


            box.innerHTML = html;

        })

        .catch(console.error);

    }


    

    static deleteUser(id) {

        const confirmed =
            confirm(
                "Eliminare questo utente?"
            );


        if (!confirmed) {
            return;
        }


        Api.deleteUser(id)

        .then(res => res.json())

        .then(() => {

            this.loadUsers();

        })

        .catch(console.error);

    }



    static sendAnnouncement() {

        const message =
            document
                .getElementById(
                    "announcementMessage"
                )
                .value
                .trim();


        if (!message) {

            alert(
                "Scrivi un messaggio"
            );

            return;

        }


        Api.createAnnouncement({

            message

        })

        .then(res => res.json())

        .then(data => {

            alert(
                data.message
            );


            document
                .getElementById(
                    "announcementMessage"
                )
                .value = "";

        })

        .catch(console.error);

    }


    static editAnnouncement(
        id,
        oldMessage
    ) {

        const message =
            prompt(
                "Modifica annuncio:",
                oldMessage
            );


        if (!message) {
            return;
        }


        Api.updateAnnouncement(

            id,

            { message }

        )

        .then(res => res.json())

        .then(() => {

            this.loadAnnouncements();

        })

        .catch(console.error);

    }



    static deleteAnnouncement(id) {

        const confirmed =
            confirm(
                "Eliminare questo annuncio?"
            );


        if (!confirmed) {
            return;
        }


        Api.deleteAnnouncement(id)

        .then(res => res.json())

        .then(() => {

            this.loadAnnouncements();

        })

        .catch(console.error);

    }

}


AdminUsersPage.init();