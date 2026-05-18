class Api {

    // =======================
    // CONFIG
    // =======================
    static BASE_URL =
        "http://localhost:8080";



    // =======================
    // HEADERS
    // =======================
    static getHeaders() {

        const token =
            Auth.getToken();


        const headers = {

            "Content-Type":
                "application/json"

        };


        if (token) {

            headers[
                "Authorization"
            ] =

                "Bearer " + token;

        }


        return headers;

    }



    // =======================
    // PUBLIC HEADERS
    // =======================
    static getPublicHeaders() {

        return {

            "Content-Type":
                "application/json"

        };

    }



    // =======================
    // AUTHENTICATION
    // =======================

    // LOGIN
    static login(
        email,
        password
    ) {

        return fetch(

            `${this.BASE_URL}/login`,

            {

                method: "POST",

                headers:
                    this.getPublicHeaders(),

                body:
                    JSON.stringify({

                        email,

                        password

                    })

            }

        );

    }



    // =======================
    // USERS
    // =======================

    // REGISTER
    static register(
        data
    ) {

        return fetch(

            `${this.BASE_URL}/user`,

            {

                method: "POST",

                headers:
                    this.getPublicHeaders(),

                body:
                    JSON.stringify(
                        data
                    )

            }

        );

    }


    // =======================
    // USERS ADMIN
    // =======================
    static getUsers() {

        return fetch(

            `${this.BASE_URL}/users`,

            {

                headers:
                    this.getHeaders()

            }

        );

    }



    static deleteUser(id) {

        return fetch(

            `${this.BASE_URL}/users/${id}`,

            {

                method: "DELETE",

                headers:
                    this.getHeaders()

            }

        );

    }


    // =======================
    // ANNOUNCEMENTS
    // =======================
    static getAnnouncements() {

        return fetch(

            `${this.BASE_URL}/announcements`,

            {

                headers:
                    this.getHeaders()

            }

        );

    }



    static createAnnouncement(
        data
    ) {

        return fetch(

            `${this.BASE_URL}/announcements`,

            {

                method: "POST",

                headers:
                    this.getHeaders(),

                body:
                    JSON.stringify(
                        data
                    )

            }

        );

    }


    static updateAnnouncement(id, data) {

        return fetch(

            `${this.BASE_URL}/announcements/${id}`,

            {

                method: "PUT",

                headers:
                    this.getHeaders(),

                body:
                    JSON.stringify(data)

            }

        );

    }



    static deleteAnnouncement(id) {

        return fetch(

            `${this.BASE_URL}/announcements/${id}`,

            {

                method: "DELETE",

                headers:
                    this.getHeaders()

            }

        );

    }



    // =======================
    // CATEGORIES
    // =======================

    // GET ALL CATEGORIES
    static getCategories() {

        return fetch(

            `${this.BASE_URL}/categories`,

            {

                headers:
                    this.getHeaders()

            }

        );

    }



    // =======================
    // TAGS
    // =======================

    // GET ALL TAGS
    static getTags() {

        return fetch(

            `${this.BASE_URL}/tags`,

            {

                headers:
                    this.getHeaders()

            }

        );

    }



    // =======================
    // POSTS
    // =======================

    // GET POSTS
    static getPosts(
        search = ""
    ) {

        return fetch(

            `${this.BASE_URL}/posts?search=${encodeURIComponent(search)}`,

            {

                headers:
                    this.getHeaders()

            }

        );

    }



    // CREATE POST
    static createPost(
        data
    ) {

        return fetch(

            `${this.BASE_URL}/posts`,

            {

                method: "POST",

                headers:
                    this.getHeaders(),

                body:
                    JSON.stringify(
                        data
                    )

            }

        );

    }



    // UPDATE POST
    static updatePost(
        id,
        data
    ) {

        return fetch(

            `${this.BASE_URL}/posts/${id}`,

            {

                method: "PUT",

                headers:
                    this.getHeaders(),

                body:
                    JSON.stringify(
                        data
                    )

            }

        );

    }



    // DELETE POST
    static deletePost(
        id
    ) {

        return fetch(

            `${this.BASE_URL}/posts/${id}`,

            {

                method: "DELETE",

                headers:
                    this.getHeaders()

            }

        );

    }



    // =======================
    // COMMENTS
    // =======================

    // GET COMMENTS
    static getComments(
        post_id
    ) {

        return fetch(

            `${this.BASE_URL}/comments?post_id=${post_id}`,

            {

                headers:
                    this.getHeaders()

            }

        );

    }



    // ADD COMMENT
    static addComment(
        data
    ) {

        return fetch(

            `${this.BASE_URL}/comments`,

            {

                method: "POST",

                headers:
                    this.getHeaders(),

                body:
                    JSON.stringify(
                        data
                    )

            }

        );

    }



    // UPDATE COMMENT
    static updateComment(
        id,
        data
    ) {

        return fetch(

            `${this.BASE_URL}/comments/${id}`,

            {

                method: "PUT",

                headers:
                    this.getHeaders(),

                body:
                    JSON.stringify(
                        data
                    )

            }

        );

    }



    // DELETE COMMENT
    static deleteComment(
        id
    ) {

        return fetch(

            `${this.BASE_URL}/comments/${id}`,

            {

                method: "DELETE",

                headers:
                    this.getHeaders()

            }

        );

    }

}