let HOST_URL = "https://mmi.unilim.fr/~mamedov1/SAE2.03-MAMEDOV/server";

let DataMovie = {};

DataMovie.add = async function(formData) {
    let response = await fetch(HOST_URL + "/script.php?todo=addMovie", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(formData)
    });
    return await response.json();
};

DataMovie.requestAllMovies = async function() {
    let response = await fetch(HOST_URL + "/script.php?todo=readmovies");
    return await response.json();
};

DataMovie.requestMovieDetails = async function(id) {
    let response = await fetch(HOST_URL + "/script.php?todo=readMovieDetail&id=" + id);
    return await response.json();
};

export { DataMovie };