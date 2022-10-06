<template>
    <div>
        <div class="blog-section row">
            <template v-if="posts.length > 0">
                <div
                    class="col-md-6 col-lg-4"
                    v-for="(post, index) in posts"
                    :key="index"
                >
                    <keep-alive>
                        <component
                            :is="postComponent"
                            v-bind="{post: post}"
                        ></component>
                    </keep-alive>
                </div>
            </template>

            <div
                class="info-box with-icon py-3 px-1 skel-hide"
                v-else
            >
                <p class="porto-info">
                    No blog matching your selection.
                </p>
            </div>

            <template>
                <div
                    class="col-md-6 col-lg-4"
                    v-for="item in [1, 2, 3, 4, 5, 6]"
                    :key="'post-skel-' + item"
                >
                    <div class="skel-post"></div>
                </div>
            </template>
        </div>
        <nav
            class="toolbox toolbox-pagination"
            v-if="perPage < totalCount"
        >
            <pagination-component
                class="border-0"
                :per-page="perPage"
                :total="totalCount"
            ></pagination-component>
        </nav>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';

import PaginationComponent from "../../shared/PaginationComponent";

import BlogSidebarComponent from "./BlogSidebarComponent";

function loadPost ( name ) {
    return () =>
        import( `../../shared/posts/${ name }.vue` ).then( ( m ) => m.default || m );
}

export default {
    components: {
        BlogSidebarComponent,
        PaginationComponent
    },
    data () {
        return {
            posts: [],
            totalCount: 0,
            page: 1,
            perPage: 6,
            certainTag: null,
            certainCategory: null,
        };
    },
    watch: {
        $route: function () {
            this.certainTag = this.$route.query.tag;
            this.certainCategory = this.$route.query.category;
            this.page = this.$route.query.page ? this.$route.query.page : 1;
            this.getPosts();
        },
    },
    computed: {
        ...mapGetters( "setting", [ "getBlogSettings" ] ),
        postComponent: function () {
            return (
                this.getBlogSettings.postType &&
                loadPost( this.getBlogSettings.postType )
            );
        }
    },
    created: function () {
        this.certainTag = this.$route.query.tag;
        this.certainCategory = this.$route.query.category;
        this.getPosts();
    },
    methods: {
        getPosts: async function () {
            if ( document.querySelector( ".skeleton-body" ) ) {
                document
                    .querySelector( ".skeleton-body" )
                    .classList.remove( "loaded" );
            }

            let params = {
                page: this.page,
                per_page: this.perPage,
            };

            if ( this.certainTag != null ) {
                params.tag = this.certainTag;
            }

            if ( this.certainCategory != null ) {
                params.category = this.certainCategory;
            }

            if ( this.$route.query.author != null ) {
                params.author = this.$route.query.author;
            }

            await window.axios
                .get( "/web/posts", {
                    params: params,
                } )
                .then( ( response ) => {
                    const { data } = response;
                    this.posts = data.posts;
                    this.totalCount = data.postsCount;

                    if ( document.querySelector( ".skeleton-body" ) )
                        document
                            .querySelector( ".skeleton-body" )
                            .classList.add( "loaded" );
                } )
                .catch( ( error ) => { } );
        },
    },
};
</script>