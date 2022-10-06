w<template>
    <main class="main">
        <nav
            aria-label="breadcrumb"
            class="breadcrumb-nav"
        >
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <router-link to="/">
                            <i class="icon-home"></i>
                        </router-link>
                    </li>
                    <li
                        class="breadcrumb-item"
                        :class="{ active: blogMeta }"
                    >
                        <router-link
                            to="/pages/blog"
                            v-if="blogMeta"
                        >Blog</router-link>
                        <template v-else>
                            Blog
                        </template>
                    </li>
                    <li
                        class="breadcrumb-item active"
                        v-if="blogMeta"
                    >
                        {{ blogMeta }}
                    </li>
                </ol>
            </div>
        </nav>

        <div class="container skeleton-body skel-shop-products">
            <div class="row">
                <div class="col-lg-9">
                    <router-view></router-view>
                </div>

                <blog-sidebar-component class="col-lg-3"></blog-sidebar-component>
            </div>
        </div>

        <div class="mb-4"></div>
    </main>
</template>
<script>
import BlogSidebarComponent from "./BlogSidebarComponent";
export default {
    components: {
        BlogSidebarComponent,
    },
    computed: {
        blogTag: function () {
            return this.$route.query && this.$route.query.tag;
        },
        blogCategory: function () {
            return this.$route.query && this.$route.query.category;
        },
        blogMeta: function () {
            return this.blogTag || this.blogCategory;
        },
    },
};
</script>