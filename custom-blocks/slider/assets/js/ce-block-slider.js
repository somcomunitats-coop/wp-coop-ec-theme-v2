(function () {
  document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".wp-block-ce-block-slider").forEach((el) => {
      debugger;
      const infinite = el.dataset.infinite === "true";
      const arrowsWrapper = document.createElement("div");
      arrowsWrapper.classList.add("ce-block-slider-arrows");
      el.appendChild(arrowsWrapper);
      el.classList.remove("loading");
      jQuery(el.children[0]).slick({
        centerMode: true,
        centerPadding: "0px",
        dots: false,
        slidesToShow: 1,
        arrows: true,
        infinite: infinite,
        appendArrows: jQuery(arrowsWrapper),
      });
    });
  });
})();
