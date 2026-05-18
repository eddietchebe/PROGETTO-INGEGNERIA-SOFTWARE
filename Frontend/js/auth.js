console.log(
    "AUTH JS LOADED"
);



class Auth {

    // =======================
    // TOKEN
    // =======================
    static getToken() {

        return localStorage.getItem(
            "token"
        );

    }



    // =======================
    // SAVE TOKEN
    // =======================
    static saveToken(
        token
    ) {

        localStorage.setItem(

            "token",

            token

        );

    }



    // =======================
    // REMOVE TOKEN
    // =======================
    static clearToken() {

        localStorage.removeItem(
            "token"
        );

    }



    // =======================
    // CURRENT USER FROM JWT
    // =======================
    static getUser() {

        const token =
            this.getToken();


        if (!token) {

            return null;
        }


        try {

            const payload =
                JSON.parse(

                    atob(
                        token.split(".")[1]
                    )

                );


            return payload.data;

        }

        catch (error) {

            return null;
        }

    }



    // =======================
    // REQUIRE LOGIN
    // =======================
    static requireAuth() {

        const token =
            this.getToken();


        if (!token) {

            alert(
                "Devi fare login"
            );


            window.location.href =
                "/html/login.html";
        }

    }



    // =======================
    // VISITOR MODE
    // =======================
    static enterAsVisitor() {

        this.clearToken();


        window.location.href =
            "/html/posts.html";

    }



    // =======================
    // LOGOUT
    // =======================
    static logout() {

        console.log(
            "LOGOUT CLICKED"
        );


        this.clearToken();


        window.location.href =
            "/html/login.html";

    }

}