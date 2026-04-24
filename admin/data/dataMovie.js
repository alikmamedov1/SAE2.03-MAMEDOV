let HOST_URL = "https://mmi.unilim.fr/~mamedov1/SAE2.03-MAMEDOV/server";

let DataMovie = {};

DataMovie.add = async function(formData) {
    let bodyParams = new URLSearchParams(formData).toString();
    let response = await fetch(HOST_URL + "/script.php?todo=addMovie", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: bodyParams
    });
    return await response.json();
};

export {DataMovie};