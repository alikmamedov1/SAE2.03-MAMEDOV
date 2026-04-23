// Убираем /server из HOST_URL, оставляем только путь к проекту
let HOST_URL = "https://mmi.unilim.fr/~mamedov1/SAE2.03-MAMEDOV"; 

let DataMovie = {};

DataMovie.requestMovies = async function(){
    // Теперь путь склеится правильно: ...MAMEDOV + /server/script.php
    let answer = await fetch(HOST_URL + "/server/script.php?todo=readmovies");
    let data = await answer.json();
    return data;
}

export {DataMovie};
