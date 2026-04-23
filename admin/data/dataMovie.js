let HOST_URL = "https://mmi.unilim.fr/~mamedov1/SAE2.03-MAMEDOV/server";

let DataMovie = {};

DataMovie.add = async function(formData) {
    let response = await fetch(HOST_URL + "/script.php?todo=addMovie", {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams(formData).toString()
    });
    return await response.json();
}

export { DataMovie };