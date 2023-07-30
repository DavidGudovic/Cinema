window.carousel = function () {
    return {
        current: 0,
        movies: [],
        interval: null,
        startCarousel: function () {
            this.interval = setInterval(() => {
                this.next();
            }, 6000);
        },
        next: function () {
            this.current =
                this.current === this.movies.length - 1 ? 0 : this.current + 1;
        },
        prev: function () {
            this.current =
                this.current === 0 ? this.movies.length - 1 : this.current - 1;
        },
        manualMove: function () {
            clearInterval(this.interval);
            this.startCarousel();
        },
        setMovies: function (movies) {
            this.movies = movies;
        },
    };
};
