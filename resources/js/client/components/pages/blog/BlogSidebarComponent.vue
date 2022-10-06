<template>
    <div>
        <div
            class="sidebar-overlay"
            @click="toggleSidebar"
        ></div>
        <div
            class="blog-sidebar-toggle"
            @click="toggleSidebar"
        >
            <i class="fas fa-sliders-h"></i>
        </div>
        <aside
            class="sidebar blog-sidebar mobile-sidebar"
            sticky-container
        >
            <div
                class="sidebar-wrapper"
                v-sticky="shouldSticky"
                sticky-offset="{ top: 69 }"
                :disabled="true"
            >
                <div class="widget widget-post-categories">
                    <h4 class="widget-title text-uppercase">Blog Categories</h4>

                    <vue-tree-list :model="treeData">
                        <template v-slot:leafNameDisplay="slotProps">
                            <router-link
                                :to="{
									path: '/pages/blog',
									query: {
										category: slotProps.model.slug,
									},
								}"
                                exact-active-class="active"
                            >{{ slotProps.model.name }} ({{
									slotProps.model.count
								}})</router-link>
                        </template>
                        <template v-slot:treeNodeIcon>
                            <span></span>
                        </template>
                    </vue-tree-list>
                </div>

                <div
                    class="widget widget-recent-posts"
                    v-if="recentPosts.length > 0"
                >
                    <h4 class="widget-title text-uppercase">Recent Posts</h4>

                    <ul class="simple-post-list">
                        <li
                            v-for="(post, index) in recentPosts"
                            :key="index"
                        >
                            <post-two-component :post="post"></post-two-component>
                        </li>
                    </ul>
                </div>

                <div
                    class="widget"
                    v-if="tags.length > 0"
                >
                    <h4 class="widget-title text-uppercase">Tags</h4>

                    <div class="tagcloud">
                        <router-link
                            v-for="(tag, index) in tags"
                            :key="index"
                            :to="{
								path: '/pages/blog',
								query: {
									tag: tag.slug,
								},
							}"
                            exact-active-class="active"
                            @click="filterByTag(index)"
                        >{{ tag.name }}</router-link>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</template>
<script>
import Sticky from "vue-sticky-directive";
import { VueTreeList, Tree, TreeNode } from "vue-tree-list";
import PostTwoComponent from "../../shared/posts/PostTwoComponent";

export default {
    components: {
        PostTwoComponent,
        VueTreeList,
    },
    directives: {
        Sticky,
    },
    props: {},
    data () {
        return {
            categories: [],
            tags: [],
            recentPosts: [],
            shouldSticky: window.innerWidth >= 992,
        };
    },
    computed: {
        treeData: function () {
            return new Tree( this.categories );
        },
    },
    created: async function () {
        await window.axios
            .get( "/web/posts/sidebar" )
            .then( ( response ) => {
                const { data } = response;
                this.categories = data.categories;
                this.tags = data.tags;
                this.recentPosts = data.recentPosts;
            } )
            .catch( ( error ) => { } );

        window.addEventListener( "resize", this.resizeHandler, {
            passive: true,
        } );
    },
    beforeDestroy: function () {
        window.removeEventListener( "resize", this.resizeHandler );
    },
    methods: {
        toggleSidebar: function () {
            document.querySelector( "body" ).classList.toggle( "sidebar-opened" );
        },
        resizeHandler: function () {
            this.shouldSticky = window.innerWidth >= 992;
        },
    },
};
</script>