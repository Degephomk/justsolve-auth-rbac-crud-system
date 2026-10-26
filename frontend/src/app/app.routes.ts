import { Routes } from '@angular/router';

import { LoginComponent } from './pages/login/login';
import { RegisterComponent} from './pages/register/register';

import { ProjectsComponent } from './pages/projects/projects';
import { SettingsComponent} from './pages/settings/settings';
import { DashboardLayoutComponent } from './layout/dashboard';
import { authGuard } from './guards/auth-guard';

export const routes: Routes = [

  // PUBLIC ROUTES
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent },


  // PROTECTED DASHBOARD
  {
    path: '',
    component: DashboardLayoutComponent,
    canActivate: [authGuard],
    children: [
      { path: 'projects', component: ProjectsComponent },
      { path: '', redirectTo: 'projects', pathMatch: 'full' },
      { path: 'settings', component: SettingsComponent },
    ]
  },

  // FALLBACK
  { path: '**', redirectTo: 'login' }
];
