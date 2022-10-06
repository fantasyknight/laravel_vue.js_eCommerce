<template>
    <div class="product-reviews-content">
        <h3 class="reviews-title">
            {{
                approvedReviewsCount > 0
                    ? `${approvedReviewsCount} review(s) for ${productName}`
                    : "Reviews"
            }}
        </h3>

        <div class="comment-list" v-if="currentReviews.length > 0" key="exists">
            <vue-tree-list
                class="comments"
                ref="treeList"
                :model="treeData"
                :default-expanded="true"
            >
                <template v-slot:leafNameDisplay="slotProps">
                    <div class="comment-block">
                        <div class="comment-header">
                            <div class="comment-arrow"></div>
                            <div class="ratings-container float-right">
                                <div class="product-ratings">
                                    <span
                                        class="ratings"
                                        :style="{
                                            width:
                                                20 * slotProps.model.rating +
                                                '%',
                                        }"
                                    ></span>
                                </div>
                            </div>
                            <span class="comment-by">
                                <strong>{{ slotProps.model.name }} –</strong>
                                {{ slotProps.model.date }}
                                <em v-if="!slotProps.model.approved"
                                    >Your comment is awating moderation</em
                                >
                            </span>
                        </div>
                        <div class="comment-content">
                            <p v-html="slotProps.model.content"></p>
                        </div>
                    </div>
                </template>
                <template v-slot:treeNodeIcon>
                    <div class="img-thumbnail">
                        <img
                            :src="$root.getUrl('client/images/blog/author.png')"
                            alt="author"
                            width="80"
                            height="80"
                        />
                    </div>
                </template>
            </vue-tree-list>
            <div class="mt-2">
                <ul
                    class="pagination justify-content-end mb-0"
                    v-if="shouldRender"
                >
                    <li
                        class="page-item"
                        :class="{ disabled: currentPage < 2 }"
                    >
                        <a
                            class="page-link page-link-btn"
                            href="#"
                            @click.prevent="findPage(currentPage - 1)"
                        >
                            <i class="icon-angle-left"></i>
                        </a>
                    </li>

                    <li class="page-item">
                        <a
                            class="page-link"
                            :class="{ active: currentPage == 1 }"
                            href="#"
                            @click.prevent="findPage(1)"
                            >{{ 1 }}</a
                        >
                    </li>

                    <li class="page-item" v-if="pagesToBeShown[0] > 2">
                        <span class="page-link">...</span>
                    </li>

                    <template v-if="pagesToBeShown.length">
                        <li
                            class="page-item"
                            v-for="page in pagesToBeShown"
                            :key="`page-${page}`"
                        >
                            <a
                                class="page-link"
                                :class="{ active: currentPage == page }"
                                href="#"
                                @click.prevent="findPage(page)"
                                >{{ page }}</a
                            >
                        </li>
                    </template>

                    <li
                        class="page-item"
                        v-if="
                            pagesToBeShown[pagesToBeShown.length - 1] <
                            lastPage - 1
                        "
                    >
                        <span class="page-link">...</span>
                    </li>

                    <li class="page-item" v-if="lastPage > 1">
                        <a
                            class="page-link"
                            :class="{ active: currentPage == lastPage }"
                            href="#"
                            @click.prevent="findPage(lastPage)"
                            >{{ lastPage }}</a
                        >
                    </li>
                    <li
                        class="page-item"
                        :class="{ disabled: currentPage === lastPage }"
                    >
                        <a
                            class="page-link page-link-btn"
                            href="#"
                            @click.prevent="findPage(lastPage)"
                        >
                            <i class="icon-angle-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <p class="no-reviews" v-else key="no-exist">
            There are no reviews yet.
        </p>

        <div class="divider"></div>

        <div class="add-product-review">
            <h3 class="review-title">
                {{
                    currentReviews.length > 0
                        ? "Add a review"
                        : `Be the first to review “${productName}“`
                }}
            </h3>
            <form
                action="#"
                class="comment-form m-0"
                @submit.prevent="productReview"
            >
                <p class="logged-in" v-if="isCustomer" key="customer">
                    <router-link
                        class="text-primary"
                        to="/pages/account/details"
                    >
                        <template v-if="reviewName">
                            Logged in as
                            {{ reviewName }}.
                        </template>
                        <template v-else
                            >You haven't set your name. Set your name
                            first.</template
                        >
                    </router-link>
                    <router-link class="text-primary" to="/pages/account"
                        >Log out?</router-link
                    >
                </p>

                <div class="rating-form">
                    <label for="rating">Your rating</label>
                    <span class="rating-stars">
                        <a class="star-1" href="#" @click.prevent="selectRating"
                            >1</a
                        >
                        <a class="star-2" href="#" @click.prevent="selectRating"
                            >2</a
                        >
                        <a class="star-3" href="#" @click.prevent="selectRating"
                            >3</a
                        >
                        <a class="star-4" href="#" @click.prevent="selectRating"
                            >4</a
                        >
                        <a class="star-5" href="#" @click.prevent="selectRating"
                            >5</a
                        >
                    </span>
                </div>

                <div class="form-group">
                    <label>Your Review</label>
                    <textarea
                        cols="5"
                        rows="6"
                        class="form-control form-control-sm"
                        v-model="reviewContent"
                        maxlength="1000"
                        required
                    ></textarea>
                </div>

                <div class="row" v-if="!isCustomer">
                    <div class="col-md-6 col-xl-12">
                        <div class="form-group">
                            <label>Your Name</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="reviewName"
                                maxlength="250"
                            />
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-12">
                        <div class="form-group">
                            <label>Your E-mail</label>
                            <input
                                type="text"
                                class="form-control form-control-sm"
                                required
                                v-model="reviewEmail"
                                maxlength="100"
                            />
                        </div>
                    </div>
                </div>

                <input
                    type="submit"
                    class="btn btn-primary font-weight-normal ls-n-15"
                    value="Submit"
                    :disabled="isCustomer && !reviewName"
                />
            </form>
        </div>
    </div>
</template>
<script>
import { VueTreeList, Tree, TreeNode } from "vue-tree-list";
import { mapGetters } from "vuex";

export default {
    components: {
        VueTreeList,
    },
    props: {
        productId: Number,
        productName: String,
        reviews: Array,
        approvedReviewsCount: Number,
    },
    data () {
        return {
            reviewRating: 0,
            reviewContent: null,
            reviewEmail: null,
            reviewName: null,
            currentPage: 1,
            perPage: 10,
        };
    },
    computed: {
        ...mapGetters( "setting", [ "getProductSettings" ] ),
        ...mapGetters( "user", [ "isCustomer", "userName", "getUser" ] ),

        treeData: function () {
            let stack = [];
            let results = this.currentReviews
                .slice(
                    ( this.currentPage - 1 ) * this.perPage,
                    this.currentPage * this.perPage
                )
                .reduce( ( acc, comment ) => {
                    if ( comment.parent === 0 ) {
                        let newNode = {
                            id: comment.id,
                            name: comment.author_name,
                            approved: comment.approved,
                            content: comment.content,
                            date: comment.created_at,
                            rating: comment.rating,
                            dragDisabled: true,
                            addTreeNodeDisabled: true,
                            addLeafNodeDisabled: true,
                            editNodeDisabled: true,
                            delNodeDisabled: true,
                            children: [],
                        };
                        acc.push( newNode );
                        stack.push( {
                            id: newNode.id,
                            children: newNode.children,
                        } );
                    }
                    return acc;
                }, [] );

            let temp, children, childNode;

            while ( stack.length ) {
                temp = stack[ stack.length - 1 ];
                stack.pop();
                children = this.currentReviews.filter(
                    ( comment ) => comment.parent === temp.id
                );
                children.forEach( ( child ) => {
                    childNode = {
                        id: child.id,
                        name: child.author_name,
                        approved: child.approved,
                        content: child.content,
                        date: child.created_at,
                        rating: child.rating,
                        dragDisabled: true,
                        addTreeNodeDisabled: true,
                        addLeafNodeDisabled: true,
                        editNodeDisabled: true,
                        delNodeDisabled: true,
                        children: [],
                    };
                    temp.children.push( childNode );
                    stack.push( {
                        id: childNode.id,
                        children: childNode.children,
                    } );
                } );
            }
            return new Tree( results );
        },

        currentReviews: function () {
            return this.reviews;
        },

        total: function () {
            return this.currentReviews.length;
        },

        shouldRender: function () {
            return this.total > this.perPage;
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
    created: function () {
        let savedInfo = JSON.parse( window.localStorage.getItem( "product" ) );
        if ( this.isCustomer ) {
            this.reviewName =
                this.getUser.first_name + " " + this.getUser.last_name;
            this.reviewEmail = this.getUser.email;
        } else if ( savedInfo ) {
            this.reviewName = savedInfo.name;
            this.reviewEmail = savedInfo.email;
        }
    },
    methods: {
        selectRating: function ( e ) {
            var parent = e.target.parentNode;
            if ( parent.querySelector( ".active" ) )
                parent.querySelector( ".active" ).classList.remove( "active" );
            e.target.classList.add( "active" );
            this.reviewRating = parseInt( e.target.innerText );
        },

        productReview: async function () {
            this.$vToastify.removeToast();
            this.$vToastify.setSettings( {
                withBackdrop: false,
                position: "top-right",
                successDuration: 1500,
            } );
            if (
                this.getProductSettings.starRatingRequired &&
                this.reviewRating == 0
            ) {
                this.$vToastify.error( "Ratings required" );
                return;
            }

            if (
                this.currentReviews.find(
                    ( review ) =>
                        review.content == this.reviewContent &&
                        review.author_email == this.reviewEmail
                )
            ) {
                this.$vToastify.error(
                    "Duplicate comment detected; it looks as if you’ve already said that!"
                );
            } else {
                this.$vToastify.setSettings( {
                    withBackdrop: true,
                    position: "center-center",
                } );
                this.$vToastify.loader( "Please wait..." );
                if ( !this.isCustomer ) {
                    window.localStorage.setItem(
                        "product",
                        JSON.stringify( {
                            name: this.reviewName,
                            email: this.reviewEmail,
                        } )
                    );
                } else {
                    this.reviewName = this.userName;
                    this.reviewEmail = this.getUser.email;
                }
                await window.axios
                    .post( "/web/products/review", {
                        product_id: this.productId,
                        rating: this.reviewRating,
                        content: this.reviewContent,
                        author_name: this.reviewName,
                        author_email: this.reviewEmail,
                    } )
                    .then( ( response ) => {
                        this.$vToastify.stopLoader();

                        this.currentReviews.push( {
                            ...response.data.review,
                            parent: 0,
                        } );

                        if ( response.data.review.approved ) {
                            this.$emit( "new-approved-review" );
                        }

                        this.reviewContent = "";
                    } )
                    .catch( ( error ) => {
                        this.$vToastify.stopLoader();
                        this.$vToastify.setSettings( {
                            withBackdrop: false,
                            position: "top-right",
                            errorDuration: 1500,
                        } );
                        this.$vToastify.error( "Comment could not be empty" );
                    } );
            }
        },

        findPage: function ( page ) {
            this.currentPage = page;
        },
    },
};
</script>