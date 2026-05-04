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

DataMovie.requestMovies = async function (age = 0) {
    let response = await fetch(`${HOST_URL}/script.php?todo=readmovies&age=${age}`);
    return await response.json();
};

DataMovie.addFavorite = async function(id_profile, id_movie) {
    let response = await fetch(`${HOST_URL}/script.php?todo=addFavorite&id_profile=${id_profile}&id_movie=${id_movie}`);
    return await response.json();
};

DataMovie.getFavorites = async function(id_profile) {
    let response = await fetch(`${HOST_URL}/script.php?todo=getFavorites&id_profile=${id_profile}`);
    return await response.json();
};

DataMovie.removeFavorite = async function(id_profile, id_movie) {
    const response = await fetch(`${HOST_URL}/script.php?todo=removeFavorite&id_profile=${id_profile}&id_movie=${id_movie}`);
    return await response.json();
};

export { DataMovie };