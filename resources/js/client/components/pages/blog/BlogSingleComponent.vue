<template>
    <div v-if="post">
        <div class="skel-single-post"></div>
        <article class="post single mb-0">
            <div
                class="post-media"
                v-if="loaded && getPostSettings.showPostMedia"
            >
                <owl-carousel-component
                    class="post-slider"
                    :options="{
						items: 1,
						loop: false,
						dots: true,
					}"
                    v-if="post.media.length > 0"
                >
                    <img
                        v-for="(image, index) in post.media"
                        :key="index"
                        v-lazy="$root.getUrl(image.copy_link, true)"
                        :alt="image.alt_text ? image.alt_text : 'post'"
                        :width="image.width"
                        :height="image.height"
                    />
                </owl-carousel-component>
            </div>

            <div class="post-body">
                <div class="post-date">
                    <span class="day">{{ day }}</span>
                    <span class="month">{{ month }}</span>
                </div>

                <h2 class="post-title">{{ post.title }}</h2>

                <div class="post-meta">
                    <span v-if="getPostSettings.showMetaDate">
                        <i class="icon-calendar"></i>
                        {{ fullDate }}
                    </span>
                    <span v-if="getPostSettings.showMetaAuthor">
                        <i class="icon-user"></i>By
                        <router-link :to="{
								path: '/pages/blog',
								query: {
									author: post.author.id,
								},
							}">{{ authorName }}</router-link>
                    </span>
                    <span v-if="getPostSettings.showPostCategory">
                        <i class="icon-folder-open"></i>
                        <template v-for="(category, index) in post.categories">
                            <router-link
                                :key="index"
                                :to="{
									path: '/pages/blog',
									query: {
										category: category.slug,
									},
								}"
                            >{{ category.name }}</router-link>
                            {{ post.categories.length - 1 > index ? "," : "" }}
                        </template>
                    </span>
                </div>

                <div
                    class="post-content"
                    v-html="post.description"
                ></div>

                <div
                    class="post-share"
                    v-pre
                >
                    <h3>
                        <i class="icon-forward"></i>Share this post
                    </h3>

                    <div class="social-icons">
                        <a
                            href="#"
                            class="social-icon social-facebook"
                            target="_blank"
                            title="Facebook"
                        >
                            <i class="icon-facebook"></i>
                        </a>
                        <a
                            href="#"
                            class="social-icon social-twitter"
                            target="_blank"
                            title="Twitter"
                        >
                            <i class="icon-twitter"></i>
                        </a>
                        <a
                            href="#"
                            class="social-icon social-linkedin"
                            target="_blank"
                            title="Linkedin"
                        >
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a
                            href="#"
                            class="social-icon social-mail"
                            target="_blank"
                            title="Email"
                        >
                            <i class="icon-mail-alt"></i>
                        </a>
                    </div>
                </div>

                <div
                    class="post-author"
                    v-if="getPostSettings.showAuthorInformation"
                >
                    <h3>
                        <i class="far fa-user"></i>Author
                    </h3>

                    <figure>
                        <img
                            :src="$root.getUrl('client/images/blog/author.png')"
                            alt="author"
                            width="80"
                            height="80"
                        />
                    </figure>

                    <div class="author-content">
                        <h4>
                            <router-link
                                :title="'Posts by ' + authorName"
                                :to="{
									path: '/pages/blog',
									query: {
										author: post.author.id,
									},
								}"
                            >{{ authorName }}</router-link>
                        </h4>
                        <p>{{ post.author.description }}</p>
                    </div>
                </div>

                <div
                    class="post-comments"
                    v-if="treeData.children && treeData.children.length && getPostSettings.showComments"
                >
                    <h3>
                        <i class="far fa-comments"></i>
                        Comments
                        <span v-if="getPostSettings.showCommentsCount">
                            ({{ post.comments_count }})
                        </span>
                    </h3>

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
                                    <span class="comment-by">
                                        <strong>
                                            {{
                                            slotProps.model.name
                                            }}
                                        </strong>
                                        <em v-if="!slotProps.model.approved">
                                            Your comment is awating
                                            moderation
                                        </em>
                                        <span
                                            class="float-right"
                                            v-if="post.allow_comments"
                                        >
                                            <a
                                                v-if="slotProps.model.depth < 4"
                                                href="javascript:;"
                                                class="comment-action comment-reply"
                                                @click="
													commentReplyForm(
														slotProps.model
													)
												"
                                            >Reply</a>
                                        </span>
                                    </span>
                                </div>
                                <div class="comment-content">
                                    <p v-html="slotProps.model.content"></p>
                                </div>
                                <div class="comment-footer">
                                    <span class="date float-right">
                                        {{
                                        slotProps.model.date
                                        }}
                                    </span>
                                </div>
                            </div>
                        </template>
                        <template v-slot:treeNodeIcon>
                            <div class="img-thumbnail">
                                <img
                                    :src="
										$root.getUrl(
											'client/images/blog/author.png'
										)
									"
                                    alt="author"
                                    width="80"
                                    height="80"
                                />
                            </div>
                        </template>
                    </vue-tree-list>
                </div>

                <div
                    id="respond"
                    class="comment-respond"
                    v-if="post.allow_comments"
                >
                    <h3 id="respond-title">
                        Leave a Reply
                        <small>
                            <a
                                class="comment-action comment-cancel-reply"
                                id="cancel-respond"
                                href="javascript:;"
                                @click="resetReplyForm"
                            >Cancel reply</a>
                        </small>
                    </h3>

                    <form
                        action="#"
                        method="post"
                        @submit.prevent="postComment"
                    >
                        <p
                            class="logged-in"
                            v-if="isCustomer"
                            key="customer"
                        >
                            <router-link
                                class="text-primary"
                                to="/pages/account/details"
                            >
                                <template v-if="userName">Logged in as {{ userName }}.</template>
                                <template v-else>
                                    You haven't set your name. Set your name
                                    first.
                                </template>
                            </router-link>
                            <router-link
                                class="text-primary"
                                to="/pages/account"
                            >Log out?</router-link>
                        </p>
                        <p
                            v-else
                            key="guest"
                        >
                            Your email address will not be published. Required
                            fields are marked *
                        </p>
                        <div class="form-group required-field">
                            <label>Comment</label>
                            <textarea
                                cols="30"
                                rows="1"
                                class="form-control"
                                v-model="content"
                                maxlength="1000"
                                required
                            ></textarea>
                        </div>

                        <template v-if="!isCustomer">
                            <div class="form-group required-field">
                                <label>Name</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="name"
                                    required
                                />
                            </div>

                            <div class="form-group required-field">
                                <label>Email</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    v-model="email"
                                    required
                                />
                            </div>

                            <div class="form-group">
                                <label>Website</label>
                                <input
                                    type="url"
                                    class="form-control"
                                    v-model="website"
                                />
                            </div>

                            <div class="form-group">
                                <label class="mb-0">
                                    <input
                                        type="checkbox"
                                        v-model="saveInfo"
                                    />
                                    Save my name, email, and website in this
                                    browser for the next time I comment.
                                </label>
                            </div>
                        </template>

                        <div class="form-footer my-0">
                            <button
                                type="submit"
                                class="btn btn-sm btn-primary font-weight-normal"
                                :disabled="isCustomer && !userName"
                            >Post Comment</button>
                        </div>
                    </form>
                </div>
            </div>
        </article>

        <div
            class="divider"
            v-if="relatedPosts.length > 0 && getPostSettings.showRelatedPosts"
        ></div>

        <div
            class="related-posts"
            v-if="relatedPosts.length > 0 && getPostSettings.showRelatedPosts"
        >
            <h4>Related Posts</h4>

            <owl-carousel-component
                class="related-posts-carousel"
                :options="{
					items: 3,
					margin: 20,
					loop: false,
					dots: false,
					responsive: {
						0: {
							items: 1,
						},
						560: {
							items: 2,
						},
						750: {
							items: 3,
						},
					},
				}"
                v-if="loaded"
            >
                <post-three-component
                    v-for="(relatedPost, index) in relatedPosts"
                    :key="index"
                    :post="relatedPost"
                ></post-three-component>
            </owl-carousel-component>
        </div>
    </div>
</template>
<script>
import { format } from "date-format-parse";
import { VueTreeList, Tree, TreeNode } from "vue-tree-list";
import { mapGetters } from "vuex";

import OwlCarouselComponent from "../../shared/OwlCarouselComponent";
import PostThreeComponent from "../../shared/posts/PostThreeComponent";

export default {
    components: {
        VueTreeList,
        PostThreeComponent,
        OwlCarouselComponent,
    },
    data () {
        return {
            id: this.$route.params.id,
            post: null,
            relatedPosts: [],
            commentTo: null,
            content: "",
            name: "",
            email: "",
            website: "",
            saveInfo: false,
            treeData: null,
            loaded: false,
        };
    },
    computed: {
        ...mapGetters( "user", [ "isCustomer", "getUser", "userName" ] ),
        ...mapGetters( "setting", [ "getPostSettings" ] ),
        authorName: function () {
            return (
                this.post.author.first_name + " " + this.post.author.last_name
            );
        },
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
        fullDate: function () {
            return format( this.post.created_at, "MMMM DD, YYYY" );
        },
        sameContentExists: function () {
            return this.post.comments.find(
                ( comment ) => comment.content === this.content
            );
        }
    },
    watch: {
        $route: function () {
            this.getPost();
        },
    },
    created: function () {
        this.getPost();
    },
    methods: {
        getPost: async function () {
            if ( document.querySelector( ".skeleton-body" ) ) {
                document
                    .querySelector( ".skeleton-body" )
                    .classList.remove( "loaded" );
            }

            let savedInfo = JSON.parse( window.localStorage.getItem( "post" ) );
            if ( this.isCustomer ) {
                this.name =
                    this.getUser.first_name + " " + this.getUser.last_name;
                this.email = this.getUser.email;
            } else if ( savedInfo ) {
                this.name = savedInfo.name;
                this.email = savedInfo.email;
                this.website = savedInfo.website;
                this.saveInfo = true;
            }
            this.loaded = false;
            await window.axios
                .get( "/web/posts/" + this.$route.params.slug, {
                    params: {
                        author: this.email,
                    },
                } )
                .then( ( response ) => {
                    this.post = response.data.post;
                    this.relatedPosts = response.data.relatedPosts;
                    this.treeData = new Tree( this.constructTree() );
                    this.loaded = true;

                    if ( document.querySelector( ".skeleton-body" ) )
                        document
                            .querySelector( ".skeleton-body" )
                            .classList.add( "loaded" );
                } )
                .catch( ( error ) => {
                    this.$router.push( "/pages/404" );
                } );
        },
        constructTree: function () {
            let stack = [];
            let results = this.post.comments.reduce( ( acc, comment ) => {
                if ( comment.parent === 0 ) {
                    let newNode = {
                        id: comment.id,
                        name: comment.author_name,
                        approved: comment.approved,
                        content: comment.content,
                        date: comment.created_at,
                        dragDisabled: true,
                        addTreeNodeDisabled: true,
                        addLeafNodeDisabled: true,
                        editNodeDisabled: true,
                        delNodeDisabled: true,
                        children: [],
                        depth: comment.depth,
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
                children = this.post.comments.filter(
                    ( comment ) => comment.parent === temp.id
                );
                children.forEach( ( child ) => {
                    childNode = {
                        id: child.id,
                        name: child.author_name,
                        approved: child.approved,
                        content: child.content,
                        date: child.created_at,
                        dragDisabled: true,
                        addTreeNodeDisabled: true,
                        addLeafNodeDisabled: true,
                        editNodeDisabled: true,
                        delNodeDisabled: true,
                        children: [],
                        depth: child.depth,
                    };
                    temp.children.push( childNode );
                    stack.push( {
                        id: childNode.id,
                        children: childNode.children,
                    } );
                } );
            }
            return results;
        },
        commentReplyForm: function ( node ) {
            let commentToReply = document.getElementById( node.id ).parentNode;
            let commentForm = document.getElementById( "respond" );

            document.getElementById( "cancel-respond" ).classList.add( "show" );
            document.getElementById( "respond-title" ).firstChild.textContent =
                "Reply to " + node.name;
            commentToReply.appendChild( commentForm );
            this.commentTo = node;
        },
        resetReplyForm: function () {
            let commentForm = document.getElementById( "respond" );

            document.getElementById( "cancel-respond" ).classList.remove( "show" );
            document.getElementById( "respond-title" ).firstChild.textContent =
                "Leave a Reply";
            this.$el.querySelector( ".post-body" ).appendChild( commentForm );
            this.commentTo = this.treeData;
            this.content = "";
        },
        postComment: async function () {
            if ( this.sameContentExists ) {
                this.$vToastify.removeToast();
                this.$vToastify.setSettings( {
                    withBackdrop: false,
                    position: "top-right",
                    successDuration: 1500,
                } );
                return this.$vToastify.error( "Duplicate comment detected" );
            }

            if ( !this.isCustomer ) {
                if ( this.saveInfo ) {
                    window.localStorage.setItem(
                        "post",
                        JSON.stringify( {
                            name: this.name,
                            email: this.email,
                            website: this.website,
                        } )
                    );
                }
            } else {
                this.name = this.userName;
                this.email = this.getUser.email;
                this.website = "";
            }

            await window.axios
                .post( "/web/posts/comment", {
                    post_id: this.post.id,
                    parent: this.commentTo ? this.commentTo.id : 0,
                    content: this.content,
                    author_name: this.name,
                    author_email: this.email,
                    website: this.website,
                } )
                .then( ( response ) => {
                    let comment = response.data.comment;
                    let node = new TreeNode( {
                        id: comment.id,
                        name: comment.author_name,
                        approved: comment.approved,
                        content: comment.content,
                        date: comment.created_at,
                        dragDisabled: true,
                        addTreeNodeDisabled: true,
                        addLeafNodeDisabled: true,
                        editNodeDisabled: true,
                        delNodeDisabled: true,
                        children: [],
                        depth: comment.depth,
                    } );

                    if ( comment.approved ) {
                        this.post.comments_count++;
                    }

                    if ( this.commentTo ) {
                        this.commentTo.addChildren( node );
                    } else {
                        this.treeData.addChildren( node );
                    }
                    this.post.comments.push( comment );
                    this.resetReplyForm();
                } )
                .catch( ( error ) => {
                    this.$vToastify.removeToast();
                    this.$vToastify.setSettings( {
                        withBackdrop: false,
                        position: "top-right",
                        successDuration: 1500,
                    } );
                    return this.$vToastify.error( "Your content is too long." );
                } );
        },
    },
};
</script>