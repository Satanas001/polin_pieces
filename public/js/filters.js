window.onload = () => {
    const FiltersForm = document.querySelector("#filters");

    // On boucle sur les input
    document.querySelectorAll("#filters option").forEach(option => {
        option.addEventListener("change", () => {
           
            // On récupère les données du formulaire
            const Form = new FormData(FiltersForm);

            // On fabrique la "queryString"
            const Params = new URLSearchParams();

            Form.forEach((value, key) => {
                Params.append(key, value);
            });

            // On récupère l'url active
            const Url = new URL(window.location.href);

            // On lance la requête ajax
            fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            }).then(response =>
                response.json()
            ).then(data => {
                // On va chercher la zone de contenu
                const details = document.querySelector("#details");

                // On remplace le contenu
                details.innerHTML = data.details;

            }).catch(e => alert(e));

        });
    });
}