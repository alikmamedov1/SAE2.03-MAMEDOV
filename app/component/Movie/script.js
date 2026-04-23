
let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};


Movie.format = function (movies) {

    if (!movies || movies.length === 0) {
        return `<p class="no-movies">Aucun film disponible pour le moment.</p>`;
    }

    let htmlFinal = '<div class="movie-list">';


    movies.forEach(movie => {
        let card = template;
        card = card.replace(/{{title}}/g, movie.name);
        card = card.replace("{{poster}}", "../server/images/" + movie.image);
        card = card.replace("{{year}}", movie.year || "");
        card = card.replace("{{description}}", movie.description);
        card = card.replace("{{director}}", movie.director);
        card = card.replace("{{trailer}}", movie.trailer);
        
        htmlFinal += card;
    });

    htmlFinal += '</div>';
    return htmlFinal;
};

export { Movie };