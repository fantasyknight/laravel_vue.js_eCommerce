<template>
    <div class="owl-carousel owl-theme" :id="id">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        options: {
            type: Object,
        },
    },
    data: function () {
        return {
            carouselOptions: {
                loop: false,
                margin: 20,
                responsiveClass: true,
                nav: false,
                navText: [
                    '<i class="icon-angle-left">',
                    '<i class="icon-angle-right">',
                ],
                dots: true,
                autoplay: true,
                autoplayTimeout: 15e3,
                items: 1,
            },
            id: "10",
        };
    },

    created: function () {
        this.carouselOptions = {
            ...this.carouselOptions,
            ...this.options,
        };
        this.id = Math.random().toString(36).substring(2, 15);
    },

    mounted: function () {
        require("owl.carousel");
        var owl = $("#" + this.id);

        owl.on("initialize.owl.carousel", () => {
            this.$emit("initialize");
        });

        owl.on("initialized.owl.carousel", () => {
            this.$emit("initialized");
        });

        this.create();

        $("#" + this.prevHandler).click(function () {
            owl.trigger("prev.owl.carousel");
        });

        $("#" + this.nextHandler).click(function () {
            owl.trigger("next.owl.carousel");
        });

        owl.on("changed.owl.carousel", (event) => {
            this.$emit("changed", event);
            if (
                $(event.currentTarget.closest(".product-single-carousel"))
                    .length > 0
            ) {
                var customDots = $(event.currentTarget)
                    .closest(".product-single-gallery")
                    .find("#carousel-custom-dots");
                if (
                    customDots.length > 0 &&
                    customDots.hasClass("vertical-thumbs")
                ) {
                    var activeDot = customDots.find(".owl-dot.active");
                    if (activeDot.length > 0) {
                        activeDot.removeClass("active");
                    }
                    customDots
                        .children()
                        .eq(event.item.index)
                        .addClass("active");
                } else if (customDots.length > 0) {
                    var activeDot = customDots.find(".owl-dot.active");
                    if (activeDot.length > 0) {
                        activeDot.removeClass("active");
                    }

                    var activeDotParent = customDots
                        .find(".owl-item")
                        .eq(event.item.index);
                    if (!activeDotParent.hasClass("active")) {
                        activeDotParent
                            .closest(".owl-carousel")
                            .trigger("to.owl.carousel", [
                                activeDotParent.index(),
                                300,
                            ]);
                    }
                    activeDotParent.children().addClass("active");
                }
            }
        });

        $("#carousel-custom-dots .owl-dot").click(function () {
            var index = $(this).index();
            if ($(this).closest(".owl-carousel").length > 0) {
                index = $(this).parent().index();
            }
            $(this)
                .closest(".product-single-gallery")
                .find(".product-single-carousel")
                .trigger("to.owl.carousel", [index, 300]);
        });

        if (!this.loop) {
            owl.on("changed.owl.carousel", (event) => {
                // start
                if (event.item.index === 0) {
                    this.showPrev = false;
                    this.showNext = true;
                } else {
                    const currentEl = Math.floor(
                        event.item.index + event.page.size
                    );
                    // last
                    if (currentEl === event.item.count) {
                        this.showPrev = true;
                        this.showNext = false;
                    } else {
                        this.showPrev = true;
                        this.showNext = true;
                    }
                }
            });
        }
    },

    methods: {
        create: function () {
            $("#" + this.id).owlCarousel(this.carouselOptions);
        },

        destroy: function () {
            $("#" + this.id).trigger("destroy.owl.carousel");
        },
    },
};
</script>