<template>
    <div>
        <div class="main">
            <div class="main__content">
                <h2 class="main__header">Оценки уборщиков</h2>
                <div class="dashboard">
                    <div class="dashboard__content">
                        <div class="dashboard__diagramm">
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-five">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-four">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-three">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-two">

                            </div>
                            <div class="dashboard__diagramm-item dashboard__diagramm-item_mark-one">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

}
</script>

<style>
    .dashboard__content {
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
        max-width: 980px;
        height: 500px;
        border-radius: 20px;
        border: 3px solid slateblue;
    }

    .dashboard__diagramm {
        border: 1px solid blue;
        max-width: 780px;
        height: 400px;
        margin-top: 30px;
        margin-left: auto;
        margin-right: auto;
        border-radius: 20px;
        display: flex;
        align-items: flex-end;
    }

    .dashboard__diagramm-item {
        flex: 1;
        border-radius: 20px;
    }

    .dashboard__diagramm-item_mark-five {
        background-color: springgreen;
        height: 50%;
    }

    .dashboard__diagramm-item_mark-four {

    }

    .dashboard__diagramm-item_mark-three {

    }

    .dashboard__diagramm-item_mark-two {

    }

    .dashboard__diagramm-item_mark-one {

    }
</style>