class AdminAnnouncements {

    static send() {

        const message =
            document
                .getElementById(
                    "message"
                )
                .value
                .trim();


        if (!message) {
            return;
        }


        Api.createAnnouncement({

            message

        })

        .then(res => res.json())

        .then(() => {

            alert(
                "Messaggio inviato"
            );

        })

        .catch(console.error);

    }

}