function selectCategory(event) {
  event.preventDefault();
  let $category = $(event.currentTarget).val();
  if ($category.length > 0) {
    window.location.href = "/cursos/" + $category;
  }
  return false;
}

$(function () {
  $("#categories.select2").select2({
    placeholder: "-- CATEGORIAS --",
    language: "pt-BR",
  });

  $("#categories").on("change", selectCategory);

  $("#customize-categorias").easyPaginate({
    paginateElement: ".category-item",
    elementsPerPage: 12,
  });
});
