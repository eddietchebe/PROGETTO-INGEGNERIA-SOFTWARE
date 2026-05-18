console.log(
    "REGISTER JS LOADED"
);



class RegisterPage {

    // =======================
    // INIT
    // =======================
    static init() {

        document
            .getElementById(
                "registerBtn"
            )
            .addEventListener(

                "click",

                () =>
                    this.register()

            );

    }



    // =======================
    // REGISTER
    // =======================
    static register() {

        const name =
            document
                .getElementById(
                    "name"
                )
                .value
                .trim();


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


        const role =
            document
                .getElementById(
                    "role"
                )
                .value;


        const adminKey =
            document
                .getElementById(
                    "adminKey"
                )
                .value;


        const result =
            document
                .getElementById(
                    "result"
                );



        // VALIDATION
        if (

            !name ||

            !email ||

            !password

        ) {

            result.innerHTML = `
                <span style="color:red;">
                    ⚠ Compila tutti i campi
                </span>
            `;

            return;
        }



        Api.register({

            name,

            email,

            password,

            role,

            admin_key:
                adminKey

        })

        .then(res => res.text())

        .then(text => {

            console.log(
                "RAW RESPONSE:",
                text
            );


            let data;


            try {

                data =
                    JSON.parse(
                        text
                    );

            }

            catch (error) {

                result.innerHTML = `
                    <span style="color:red;">
                        ❌ Risposta non valida dal server
                    </span>
                `;

                return;
            }



            // SUCCESS
            if (data.message) {

                result.innerHTML = `
                    <span style="
                        color:green;
                        font-weight:bold;
                    ">
                        ✅ Registrazione completata con successo!
                    </span>
                `;


                setTimeout(() => {

                    window.location.href =
                        "/html/login.html";

                }, 2000);

            }



            // ERROR
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
RegisterPage.init();