let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movie) {
    let html = template;
    
    // 1. Создаем HTML кнопки в отдельном блочном контейнере
    let favoriteButton = "";
    if (window.state && window.state.activeProfile) {
        favoriteButton = `
            <div class="fav-container">
                <button class="btn-fav" onclick="event.stopPropagation(); C.handlerAddFavorite(${movie.id})">
                    Ajouter aux favoris
                </button>
            </div>`;
    }

    // 2. Делаем всю карточку кликабельной
    html = html.replace('class="movie-card"', 'class="movie-card" style="cursor:pointer" onclick="C.handlerDetail(' + movie.id + ')"');
    
    // 3. Заменяем стандартные метки данными из объекта movie
    html = html.replace(/{{id}}/g, movie.id);
    html = html.replace(/{{name}}/g, movie.name); 
    html = html.replace(/{{description}}/g, movie.description);
    html = html.replace(/{{title}}/g, movie.name); 
    html = html.replace(/{{year}}/g, movie.year);
    html = html.replace(/{{director}}/g, movie.director);
    
    // Обработка ссылки на трейлер
    let trailerUrl = movie.trailer || "#";
    html = html.replace(/{{trailer}}/g, trailerUrl);
    
    // Подготовка путей к изображениям
    let imageUrl = "../server/images/" + movie.image;
    html = html.replace(/{{image}}/g, imageUrl);
    html = html.replace(/{{poster}}/g, imageUrl);

    // 4. Вставляем кнопку в самый конец контента карточки
    // Мы ищем последний закрывающий тег </div> в шаблоне и вставляем кнопку перед ним.
    // Это гарантирует, что она окажется под текстом трейлера.
    let lastIndex = html.lastIndexOf('</div>');
    if (lastIndex !== -1) {
        html = html.substring(0, lastIndex) + favoriteButton + html.substring(lastIndex);
    }
    
    return html;
};

export { Movie };