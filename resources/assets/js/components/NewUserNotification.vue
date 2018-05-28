<template>
    <li v-on:click="markAsRead">
        <div class="dropdown show">
          <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Notifications <span class="badge badge-light">{{unreadNotifications.length}}</span>
          </a>

          <div class="dropdown-menu" aria-labelledby="dropdownMenuLink" style="left:auto;right:0;width:300px">

            <ul style="list-style-type:none;margin:0px;padding:0px;">
              <li style="background-color:#ddd;margin-bottom:2px" v-for="unreadNotification in unreadNotifications">
                  <a href="" style="color:green;padding:3px 5px;">{{ unreadNotification.data.name }}</a>
              </li>
              <li v-for="notification in notifications">
                  <a href="" style="color:#222">{{ notification.data.name }}</a>
              </li>
            </ul>
          </div>
        </div>
    </li>
</template>

<script>
    export default {
        props:['read_notifications','unread_notifications','userid'],
        data(){
          return {
            unreadNotifications: [],
            notifications: []
          }
        },
        created: function () {
          this.fetchData();
        },
        methods: {
          fetchData: function () {
            var self = this;
            axios.get('/notifications/' + this.userid)
            .then(function (response) {
              self.unreadNotifications = response.data.unreadNotifications;
            })
            .catch(function (error) {
              console.log(error);
            });
        },

        markAsRead: function(){
            var self = this;
            axios.get('/mark_notification_as_read/' + this.userid)
            .then(function (response) {
              self.unreadNotifications = response.data.unreadNotifications;
              self.notifications = response.data.readNotifications;
            })
            .catch(function (error) {
              console.log(error);
            });
        },

      },
    }
</script>
