import { Movie } from "../Movie/script.js";

let templateFile = await fetch("./component/MovieCategory/template.html");
let template = await templateFile.text();

let MovieCategory = {};

MovieCategory.format = function (categoryName, movies) {
    let html = template;
    html = html.replace(/{{category_name}}/g, categoryName);
    
    let moviesHtml = "";
   
    movies.forEach(movie => {
        moviesHtml += Movie.format(movie);
    });
    
    html = html.replace(/{{movies_list}}/g, moviesHtml);
    return html;
};

export { MovieCategory };