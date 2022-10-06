<template>
    <article
        class="post"
        v-if="post"
    >
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
            <div class="post-date">
                <span class="day">{{ day }}</span>
                <span class="month">{{ month }}</span>
            </div>
        </div>

        <div class="post-body">
            <h4 class="post-title">
                <router-link :to="'/pages/blog/single/' + post.slug">{{
                    post.title
                }}</router-link>
            </h4>
            <div class="post-content">
                <p>{{ post.short_desc }}</p>
            </div>
            <router-link
                :to="'/pages/blog/single/' + post.slug"
                class="post-comment"
            >{{ post.comments_count }} Comments</router-link>
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
    }
};
</script>