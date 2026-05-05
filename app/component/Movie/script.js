let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

/**
 * @param {Object} movie 
 * @param {Boolean} isFavorite 
 */
Movie.format = function (movie, isFavorite = false) {
    let html = template;
    
    let favoriteButton = "";
    if (window.state && window.state.activeProfile) {
        if (isFavorite) {
            favoriteButton = `
                <div class="fav-container">
                    <button class="btn-fav btn-remove" 
                            onclick="event.stopPropagation(); C.handlerRemoveFavorite(${movie.id})">
                        Retirer des favoris
                    </button>
                </div>`;
        } else {
            favoriteButton = `
                <div class="fav-container">
                    <button class="btn-fav" 
                            onclick="event.stopPropagation(); C.handlerAddFavorite(${movie.id})">
                        Ajouter aux favoris
                    </button>
                </div>`;
        }
    }

    html = html.replace('class="movie-card"', 'class="movie-card" style="cursor:pointer" onclick="C.handlerDetail(' + movie.id + ')"');
    
    html = html.replace(/{{id}}/g, movie.id);
    html = html.replace(/{{name}}/g, movie.name); 
    html = html.replace(/{{description}}/g, movie.description);
    html = html.replace(/{{title}}/g, movie.name); 
    html = html.replace(/{{year}}/g, movie.year);
    html = html.replace(/{{director}}/g, movie.director);
    
    let trailerUrl = movie.trailer || "#";
    html = html.replace(/{{trailer}}/g, trailerUrl);
    
    let imageUrl = "../server/images/" + movie.image;
    html = html.replace(/{{image}}/g, imageUrl);
    html = html.replace(/{{poster}}/g, imageUrl);

    let lastIndex = html.lastIndexOf('</div>');
    if (lastIndex !== -1) {
        html = html.substring(0, lastIndex) + favoriteButton + html.substring(lastIndex);
    }
    
    return html;
};


export { Movie };