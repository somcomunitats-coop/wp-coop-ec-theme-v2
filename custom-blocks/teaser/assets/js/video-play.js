(function () {
    document.addEventListener("DOMContentLoaded", function () {
        const teaserBlock = document.getElementsByClassName("wp-block-teaser-block-teaser")[0];
        var playButton = document.getElementsByClassName("teaser-play")[0];
        const teaserVideo = document.getElementsByClassName("teaser-video")[0].firstElementChild.firstElementChild;
        const teaserImageContainer = document.getElementsByClassName("teaser-image")[0];
        const teaserImage = teaserImageContainer.firstElementChild;
        playButton.addEventListener('click', function (e) {
            teaserVideo.src += "&autoplay=1";
            teaserImageContainer.style.display = "none";
            teaserImage.style.display = "none";
            playButton.style.display = "none";
            e.preventDefault();
        })

    })
})();
