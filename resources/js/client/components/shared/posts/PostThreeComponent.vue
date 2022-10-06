<template>
    <article class="post">
        <div
            class="post-media"
            v-if="post.media.length"
        >
            <router-link :to="'/pages/blog/single/' + post.slug">
                <img
                    v-lazy="$root.getUrl(post.media[0].copy_link, true)"
                    :alt="
						post.media[0].alt_text ? post.media[0].alt_text : 'post'
					"
                    :width="post.media[0].width"
                    :height="post.media[0].height"
                />
            </router-link>
        </div>

        <div class="post-body">
            <div class="post-date">
                <span class="day">{{ day }}</span>
                <span class="month">{{ month }}</span>
            </div>

            <h2 class="post-title">
                <router-link :to="'/pages/blog/single/' + post.slug">
                    {{ post.title }}
                </router-link>
            </h2>

            <div class="post-content">
                <p>{{ post.short_desc }}</p>

                <router-link
                    :to="'/pages/blog/single/' + post.slug"
                    class="read-more"
                >
                    Read More
                    <i class="fa fa-angle-right"></i>
                </router-link>
            </div>
        </div>
    </article>
</template>
<script>
export default {
    props: {
        post: Object,
    },
    computed: {
        day: function () {
            return new Date( this.post.created_at ).toLocaleString( "en-us", {
                day: "2-digit",
            } );
        },
        month: function () {
            return new Date( this.post.created_at ).toLocaleString( "en-us", {
                month: "short",
            } );
        },
    },
};
</script>