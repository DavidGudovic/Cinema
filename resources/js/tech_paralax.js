function imageTrack() {
    return {
        mouseDownAt: 0,
        prevPercentage: 0,
        percentage: 0,
        onDown(e) {
            this.mouseDownAt = e.clientX || e.touches[0].clientX;
        },
        onUp() {
            this.mouseDownAt = 0;
            this.prevPercentage = this.percentage;
        },
        onMove(e) {
            if (this.mouseDownAt === 0) return;

            const mouseDelta =
                    parseFloat(this.mouseDownAt) -
                    (e.clientX || e.touches[0].clientX),
                maxDelta = window.innerWidth / 2;

            const percentage = (mouseDelta / maxDelta) * -100,
                nextPercentageUnconstrained =
                    parseFloat(this.prevPercentage) + percentage,
                nextPercentage = Math.max(
                    Math.min(nextPercentageUnconstrained, 0),
                    -100,
                );

            this.percentage = nextPercentage;

            this.$refs.track.style.transform = `translate(${nextPercentage}%, -50%)`;

            for (const image of this.$refs.track.getElementsByClassName(
                "image",
            )) {
                image.style.objectPosition = `${100 + nextPercentage}% center`;
            }
        },
    };
}
``;
