export interface UserApiModel {
  data: {
    id: number;
    username: string;
    roles: Array<string>;
    email: string;
    settings: {
      data: {
        notifications_subscriptions: Array<string>
      }
    };
  };
}
