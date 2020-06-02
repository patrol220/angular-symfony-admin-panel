import {Component, OnInit} from '@angular/core';
import {UserService} from '../../services/user/user.service';
import {UserApiModel} from '../../models/Api/user-api.model';
import {FormArray, FormBuilder, FormControl, FormGroup} from '@angular/forms';
import {MatCheckboxChange} from '@angular/material/checkbox';
import {NotificationsService} from 'angular2-notifications';

const availableNotificationsTypes = [
  {
    type: 'product_updated',
    name: 'Product updated',
    selected: null
  },
  {
    type: 'product_added',
    name: 'Product added',
    selected: null
  }
];

@Component({
  selector: 'app-user-settings',
  templateUrl: './user-settings.component.html',
  styleUrls: ['./user-settings.component.scss']
})

export class UserSettingsComponent implements OnInit {
  public user: UserApiModel;
  public availableNotificationTypes = availableNotificationsTypes;
  public saveSettingsForm: FormGroup;
  public subscriptionsNotificationsArray: FormArray;

  constructor(
    public userService: UserService,
    public formBuilder: FormBuilder,
    public notificationsService: NotificationsService
  ) {
    this.saveSettingsForm = formBuilder.group({
      notifications_subscriptions: formBuilder.array([])
    });
    this.subscriptionsNotificationsArray = this.saveSettingsForm.get('notifications_subscriptions') as FormArray;
  }

  ngOnInit(): void {

    this.userService.getCurrentlyLoggedUser(['settings'])
      .subscribe((responseData) => {
        this.user = responseData;
        this.setNotificationsState(this.user.data.settings.data.notifications_subscriptions);
      });
  }

  setNotificationsState(selectedSubscriptions: Array<string>) {
    selectedSubscriptions.forEach((subscriptionType) => {

      availableNotificationsTypes
        .find(element => element.type === subscriptionType).selected = true;

      this.subscriptionsNotificationsArray.push(new FormControl(subscriptionType));
    });
  }

  onCheckboxChange(e: MatCheckboxChange) {

    if (e.checked) {
      this.subscriptionsNotificationsArray.push(new FormControl(e.source.value));
    } else {
      let i = 0;
      this.subscriptionsNotificationsArray.controls.forEach((item: FormControl) => {
        if (item.value === e.source.value) {
          this.subscriptionsNotificationsArray.removeAt(i);
          return;
        }
        i++;
      });
    }
  }

  onSubmit(value) {
    this.user.data.settings.data.notifications_subscriptions = value.notifications_subscriptions;

    this.userService.updateCurrentlyLoggedUser(this.user)
      .subscribe(() => {
        this.notificationsService.success('Success!', 'successfully saved settings');
      });
  }
}
