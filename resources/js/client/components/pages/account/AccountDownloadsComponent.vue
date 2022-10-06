<template>
    <div class="download-table-container">
        <table
            class="table table-downloads"
            v-if="downloads.length"
        >
            <thead>
                <tr>
                    <th class="product-name">Product Name</th>
                    <th class="file-name">File Name</th>
                    <th class="download-action">Download</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="(download, index) in downloads"
                    :key="'download-' + index"
                >
                    <td class="product-title">
                        <router-link :to="'/product/default/' + download.slug">
                            {{ download.name }}
                        </router-link>
                    </td>
                    <td>
                        {{ download.fileName }}
                    </td>
                    <td class="donwload-action">
                        <a
                            :href="
								baseUrl + '/web/download?link=' + download.link
							"
                            class="btn btn-download btn-primary"
                            title="Download"
                        >
                            <i class="fas fa-download"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        <template v-else>
            <p>No downloadable available yet.</p>
            <router-link
                to="/shop/default"
                class="btn btn-primary text-transform-none mb-2"
            >Go Shop</router-link>
        </template>
    </div>
</template>
<script>
import { mapGetters } from "vuex";

export default {
    data () {
        return {
            downloads: [],
            baseUrl: window.baseUrl,
        };
    },
    computed: {
        ...mapGetters( "user", [ "getUser" ] ),
    },
    created: async function () {
        await window.axios
            .get( "/web/downloads/" + this.getUser.email )
            .then( ( response ) => {
                this.downloads = response.data;
            } )
            .catch( ( error ) => { } );
    },
};
</script>