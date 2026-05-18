class LoginPage {

    // =======================
    // INIT
    // =======================
    static init() {

        document
            .getElementById(
                "loginBtn"
            )
            .addEventListener(

                "click",

                () =>
                    this.login()

            );

    }



    // =======================
    // LOGIN
    // =======================
    static login() {

        const email =
            document
                .getElementById(
                    "email"
                )
                .value
                .trim();


        const password =
            document
                .getElementById(
                    "password"
                )
                .value
                .trim();


        const result =
            document
                .getElementById(
                    "result"
                );



        // VALIDATION
        if (

            !email ||

            !password

        ) {

            result.innerHTML = `
                <span style="color:red;">
                    ⚠ Inserisci email e password
                </span>
            `;

            return;
        }



        Api.login(

            email,

            password

        )

        .then(res => res.json())

        .then(data => {

            console.log("LOGIN RESPONSE:", data);


            if (data.token) {

                Auth.saveToken(
                    data.token
                );


                result.innerHTML = `
                    <span style="
                        color:green;
                        font-weight:bold;
                    ">
                        ✅ Login effettuato con successo!
                    </span>
                `;


                setTimeout(() => {

                    window.location.href =
                        "/html/posts.html";

                }, 1000);

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

}



// START PAGE
LoginPage.init();