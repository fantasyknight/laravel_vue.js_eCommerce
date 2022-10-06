<template>
    <ul
        class="pagination mb-0"
        v-if="shouldRender"
    >
        <li
            class="page-item"
            :class="{ disabled: currentPage < 2 }"
        >
            <router-link
                class="page-link page-link-btn"
                :to="getPageUrl(currentPage - 1)"
            >
                <i class="icon-angle-left"></i>
            </router-link>
        </li>

        <li class="page-item">
            <router-link
                class="page-link"
                exact-active-class="active"
                :to="getPageUrl(1)"
            >{{ 1 }}</router-link>
        </li>

        <li
            class="page-item"
            v-if="pagesToBeShown[0] > 2"
        >
            <span class="page-link">...</span>
        </li>

        <template v-if="pagesToBeShown.length">
            <li
                class="page-item"
                v-for="page in pagesToBeShown"
                :key="`page-${page}`"
            >
                <router-link
                    class="page-link"
                    exact-active-class="active"
                    :to="getPageUrl(page)"
                >{{ page }}</router-link>
            </li>
        </template>

        <li
            class="page-item"
            v-if="pagesToBeShown[pagesToBeShown.length - 1] < lastPage - 1"
        >
            <span class="page-link">...</span>
        </li>

        <li
            class="page-item"
            v-if="lastPage > 1"
        >
            <router-link
                class="page-link"
                exact-active-class="active"
                :to="getPageUrl(lastPage)"
            >{{ lastPage }}</router-link>
        </li>
        <li
            class="page-item"
            :class="{ disabled: currentPage === lastPage }"
        >
            <router-link
                class="page-link page-link-btn"
                :to="getPageUrl(currentPage + 1)"
            >
                <i class="icon-angle-right"></i>
            </router-link>
        </li>
    </ul>
</template>
<script>
export default {
    props: {
        perPage: Number,
        total: Number,
    },
    computed: {
        shouldRender: function () {
            return this.total > this.perPage;
        },
        currentPage: function () {
            return parseInt(
                this.$route.query.page ? this.$route.query.page : 1
            );
        },
        lastPage: function () {
            return (
                parseInt( this.total / this.perPage ) +
                ( this.total % this.perPage ? 1 : 0 )
            );
        },
        startIndex: function () {
            if ( !this.currentPage % this.perPage ) {
                return this.currentPage;
            }
            return this.perPage * parseInt( this.currentPage / this.perPage );
        },
        pagesToBeShown: function () {
            let pages = [];
            for ( let i = 0; i < Math.min( this.lastPage - 2, 3 ); i++ ) {
                if (
                    this.currentPage < 4 ||
                    this.currentPage > this.lastPage - 3
                ) {
                    if ( this.currentPage < 4 ) {
                        pages[ i ] = i + 2;
                    }
                    if (
                        this.lastPage > 4 &&
                        this.currentPage > this.lastPage - 3
                    ) {
                        pages[ i ] = this.lastPage - 3 + i;
                    }
                } else {
                    page[ i ] = this.currentPage - 1 + i;
                }
            }
            return pages;
        },
    },
    methods: {
        getPageUrl: function ( page ) {
            let originQuery = {};
            for ( let key in this.$route.query ) {
                if ( key !== "page" ) {
                    originQuery[ key ] = this.$route.query[ key ];
                }
            }
            if ( page > 1 ) {
                originQuery.page = page;
            }

            return {
                path: this.$route.path,
                query: originQuery,
            };
        },
    },
};
</script>