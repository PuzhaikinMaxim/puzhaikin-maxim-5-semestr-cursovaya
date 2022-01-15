<template>
<div class="main">
    <div class="main__content">
        <ChangeUserDataForm></ChangeUserDataForm>
        <h2 class="main__header">Пользователи</h2>
        <div class="user-data">
            <div class="user-data__content">
                <div class="user-data__item" v-for="user in users" v-bind:key="user.id">
                    <div class="user-data__id">{{user.id}}</div>
                    <div class="user-data__name" >{{user.name}}</div>
                    <div class="user-data__email">{{user.email}}</div>
                    <div class="user-data__role-name">{{user.role_name}}</div>
                    <div class="user-data__created-at">{{user.created_at}}</div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import ChangeUserDataForm from './ChangeUserDataComponent.vue'
export default {
    components: {
        ChangeUserDataForm
    },
    data(){
        return{
            users: []
        }
    },
    methods:{

    },
    created() {
        axios.get('/api/getAllUsersInfo').then(response=>{
            this.users = response.data
        }).catch((error) => {

        })
    }
}
</script>

<style>
    .user-data {
        padding-top: 30px;
    }

    .user-data__content {
        margin-left: auto;
        margin-right: auto;
        background-color: lightgray;
        padding: 20px 20px 20px 20px;
        border-radius: 10px;
    }

    .user-data__item {
        margin-top: 10px;
        display: flex;
        justify-content: space-between;
    }

    .user-data__id {
        max-width: 60px;
        min-width: 40px;
    }

    .user-data__name {
        max-width: 400px;
        flex: 1;
        overflow-wrap: break-word;
    }

    .user-data__email {
        max-width: 400px;
        flex: 1;
        overflow-wrap: break-word;
    }

    .user-data__role-name {
        max-width: 250px;
        flex: 1;
        overflow-wrap: break-word;
    }

    .user-data__created-at {
        max-width: 250px;
        flex: 1;
        overflow-wrap: break-word;
    }

    @media (max-width: 1440px) {
        .user-data__name {
            max-width: 300px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__email {
            max-width: 300px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__role-name {
            max-width: 200px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__created-at {
            max-width: 200px;
            flex: 1;
            overflow-wrap: break-word;
        }
    }

    @media (max-width: 1120px) {
        .user-data__name {
            max-width: 250px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__email {
            max-width: 250px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__role-name {
            max-width: 150px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__created-at {
            max-width: 150px;
            flex: 1;
            overflow-wrap: break-word;
        }
    }

    @media (max-width: 900px) {
        .user-data__name {
            max-width: 175px;
            font-size: 12px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__email {
            max-width: 175px;
            font-size: 12px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__role-name {
            max-width: 75px;
            font-size: 12px;
            flex: 1;
            overflow-wrap: break-word;
        }

        .user-data__created-at {
            max-width: 75px;
            font-size: 12px;
            flex: 1;
            overflow-wrap: break-word;
        }
    }

    @media (max-width: 600px) {
        .user-data__id {
            font-size: 26px;
            font-weight: 600;
            max-width: 100%;
        }

        .user-data__item {
            margin-top: 50px;
            flex-direction: column;
            justify-content: start;
            background-color: rgb(90, 159, 168);
            padding: 10px 10px 10px 10px;
            border-radius: 10px;
        }

        .user-data__name {
            margin-top: 10px;
            max-width: 100%;
            font-size: 20px;
        }

        .user-data__email {
            margin-top: 10px;
            max-width: 100%;
            font-size: 20px;
        }

        .user-data__role-name {
            margin-top: 10px;
            max-width: 100%;
            font-size: 20px;
        }

        .user-data__created-at {
            margin-top: 10px;
            max-width: 100%;
            font-size: 20px;
        }
    }
</style>