<template>
    <div class="post-item-small">
        <div
            class="post-media"
            v-if="post.media.length"
        >
            <router-link :to="'/pages/blog/single/' + post.slug">
                <img
                    v-lazy="$root.getUrl(post.media[0].copy_link, true, 100)"
                    :alt="
						post.media[0].alt_text ? post.media[0].alt_text : 'post'
					"
                    width="50"
                    height="50"
                />
            </router-link>
        </div>
        <div class="post-info">
            <h4 class="post-title">
                <router-link :to="'/pages/blog/single/' + post.slug">
                    {{ post.title }}
                </router-link>
            </h4>
            <div class="post-date">{{ date }}</div>
        </div>
    </div>
</template>
<script>
import { format } from "date-format-parse";

export default {
    props: {
        post: Object,
    },
    computed: {
        date: function () {
            return format( this.post.created_at, "MMMM DD, YYYY" );
        },
    },
};
</script>