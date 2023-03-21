<template>
    <notificationGroup group="foo">
        <div class="flash-wrapper my-5">
            <notification v-slot="{ notifications }">
                <div v-for="notification in notifications" :key="notification.id">
                    <div v-if="notification.type === 'warning'"
                         class="flash-toast flash-warning">
                        <div class="flash-outer-container"><i class="fas fa-exclamation-circle"></i></div>
                        <div class="flash-inner-container">
                            <p class="flash-inner-container-first-child">{{ notification.title }}</p>
                            <p class="flash-inner-container-last-child">{{ notification.text }}</p>
                        </div>
                        <span class="flash-toast-button"><i class="fa fa-times"/></span>
                    </div>
                    <div v-else-if="notification.type === 'success'" class="flash-toast flash-success">
                        <div class="flash-outer-container"><i class="fas fa-check-circle"></i></div>
                        <div class="flash-inner-container">
                            <p class="flash-inner-container-first-child">{{ notification.title }}</p>
                            <p class="flash-inner-container-last-child">{{ notification.text }}</p>
                        </div>
                        <span class="flash-toast-button"><i class="fa fa-times"/></span>
                    </div>
                    <div v-else-if="notification.type === 'error'" class="flash-toast flash-error">
                        <div class="flash-outer-container"><i class="fas fa-times-circle"></i></div>
                        <div class="flash-inner-container">
                            <p class="flash-inner-container-first-child">{{ notification.title }}</p>
                            <p class="flash-inner-container-last-child">{{ notification.text }}.</p>
                        </div>
                        <span class="flash-toast-button"><i class="fa fa-times"/></span>
                    </div>
                    <div v-else class="flash-toast flash-info">
                        <div class="flash-outer-container"><i class="fas fa-info-circle"></i></div>
                        <div class="flash-inner-container">
                            <p class="flash-inner-container-first-child">Info</p>
                            <p class="flash-inner-container-last-child">New settings available on your account.</p>
                        </div>
                        <span class="flash-toast-button"><i class="fa fa-times"/></span>
                    </div>
                </div>
            </notification>
        </div>
    </notificationGroup>
</template>

<script>
export default {
    watch: {
        "$page.flash": {
            handler() {
                if (this.$page.props.flash.error) {
                    this.$notify(
                        {
                            group: "foo",
                            type: "error",
                            title: 'error',
                            text: this.$page.props.flash.error,
                        }, 5000
                    );
                } else if (this.$page.props.flash.success) {
                    this.$notify(
                        {
                            group: "foo",
                            type: "success",
                            title: 'Success',
                            text: this.$page.props.flash.success,
                        }, 5000
                    );
                } else if (this.$page.props.flash.warning) {
                    this.$notify(
                        {
                            group: "foo",
                            type: "warning",
                            title: 'Warning',
                            text: this.$page.props.flash.warning,
                        }, 5000
                    );
                } else if (this.$page.props.flash.info) {
                    this.$notify(
                        {
                            group: "foo",
                            type: "info",
                            title: 'Info',
                            text: this.$page.props.flash.info,
                        }, 5000
                    );
                }
            },
            deep: true
        },
    },
}
</script>

<style scoped>

.flash-wrapper {
    z-index: 99999;
    font-size: 14px;
    width: 380px;
    position: absolute;
    top: 0;
    right: 0;
}

.flash-toast {
    width: 100%;
    height: 80px;
    padding: 10px;
    background-color: #ffffff;
    border-radius: 7px;
    display: grid;
    grid-template-columns: 1.3fr 6fr 0.5fr;
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08)
}

.flash-success {
    border-left: 3px solid #47D764
}

.flash-error {
    border-left: 3px solid #ff355b
}

.flash-info {
    border-left: 3px solid #2F86EB
}

.flash-warning {
    border-left: 3px solid #FFC021
}

.flash-error i {
    color: #ff355b
}

.flash-info i {
    color: #2F86EB
}

.flash-warning i {
    color: #FFC021
}

.flash-toast:not(:last-child) {
    margin-bottom: 20px
}

.flash-outer-container,
.flash-inner-container {
    align-self: center
}

.flash-outer-container i {
    font-size: 35px
}

.flash-success i {
    color: #47D764
}

.flash-inner-container-first-child {
    color: #101020;
    font-weight: 600;
    font-size: 16px
}

.flash-inner-container-last-child {
    font-size: 12px;
    font-weight: 400;
    color: #656565
}

.flash-toast-button {
    align-self: flex-start;
    background-color: transparent;
    font-size: 20px;
    color: #656565;
    line-height: 0;
    cursor: pointer;
    margin-right: -30px
}
</style>
