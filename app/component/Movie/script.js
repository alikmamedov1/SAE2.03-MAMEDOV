let templateFile = await fetch("./component/Movie/template.html");
let template = await templateFile.text();

let Movie = {};

Movie.format = function (movie) {
    let html = template;
    

    html = html.replace('class="movie-card"', 'class="movie-card" style="cursor:pointer" onclick="C.handlerDetail(' + movie.id + ')"');    // Заменяем метки на данные из базы
    // Используем /g, чтобы заменить все вхождения
    html = html.replace(/{{id}}/g, movie.id);
    html = html.replace(/{{name}}/g, movie.name); 
    html = html.replace(/{{description}}/g, movie.description);
    html = html.replace(/{{title}}/g, movie.name); // На всякий случай для твоего шаблона
    html = html.replace(/{{year}}/g, movie.year);
    html = html.replace(/{{director}}/g, movie.director);
    
    // Путь к картинке
    let imageUrl = "../server/images/" + movie.image;
    html = html.replace(/{{image}}/g, imageUrl);
    html = html.replace(/{{poster}}/g, imageUrl);
    
    return html;
};

// Опять же, не забываем экспорт!
export { Movie };