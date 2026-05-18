Auth.requireAuth();



class PostForm {

    // =======================
    // CREATE POST
    // =======================
    static create() {

        const title =
            document
                .getElementById("title")
                .value
                .trim();


        const content =
            document
                .getElementById("content")
                .value
                .trim();


        const category_id =
            document
                .getElementById("category")
                .value;


        const tags =
            document
                .getElementById("tags")
                .value
                .trim()
                .split(",")

                .map(
                    tag =>
                        tag.trim()
                )

                .filter(
                    tag =>
                        tag.length > 0
                );


        const result =
            document
                .getElementById(
                    "result"
                );



        // VALIDATION
        if (

            !title ||

            !content

        ) {

            result.innerHTML = `
                <span style="color:red;">
                    ⚠ Compila tutti i campi
                </span>
            `;

            return;
        }



        Api.createPost({

            title,

            content,

            category_id,

            tags

        })

            .then(res => res.json())

            .then(data => {


                if (data.message) {

                    result.innerHTML = `
                    <span style="
                        color:green;
                        font-weight:bold;
                    ">
                        ✅ Post pubblicato con successo!
                    </span>
                `;


                    this.reset();

                }

                else {

                    result.innerHTML = `
                    <span style="color:red;">
                        ❌ ${data.error}
                    </span>
                `;
                }

            })

            .catch(error => {

                console.error(
                    error
                );

                result.innerHTML = `
                <span style="color:red;">
                    ❌ Errore di connessione
                </span>
            `;

            });

    }



    // =======================
    // RESET FORM
    // =======================
    static reset() {

        document
            .getElementById(
                "title"
            ).value = "";


        document
            .getElementById(
                "content"
            ).value = "";


        document
            .getElementById(
                "tags"
            ).value = "";

    }

}