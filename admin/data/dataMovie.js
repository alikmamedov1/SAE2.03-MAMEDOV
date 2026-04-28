let DataMovie = {};

DataMovie.requestAllMovies = async function () {
    // ВАЖНО: путь должен вести в папку server, которая находится НА УРОВЕНЬ ВЫШЕ папки app
    let response = await fetch("../server/script.php?todo=readMovies");
    return await response.json();
};

DataMovie.requestMovieDetails = async function (id) {
    let response = await fetch("../server/script.php?todo=readDetail&id=" + id);
    return await response.json();
};

export { DataMovie };