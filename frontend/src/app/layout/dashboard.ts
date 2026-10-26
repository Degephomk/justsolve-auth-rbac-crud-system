import { Component } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterOutlet, RouterLink } from '@angular/router';
import { MaterialModule } from '../shared/material/material-module';

@Component({
  standalone: true,
  selector: 'app-dashboard-layout',
  imports: [CommonModule, RouterOutlet, RouterLink, MaterialModule],
  template: `
    <mat-sidenav-container class="sidenav-container">

      <!-- SIDEBAR -->
      <mat-sidenav mode="side" opened class="sidenav">
        <mat-toolbar color="primary">Menu</mat-toolbar>

        <mat-nav-list>

          <a mat-list-item routerLink="/projects">
            <mat-icon>folder</mat-icon>
            <span>Projects</span>
          </a>

          <a mat-list-item routerLink="/settings">
            <mat-icon>settings</mat-icon>
            <span>Settings</span>
          </a>

        </mat-nav-list>
      </mat-sidenav>

      <!-- MAIN CONTENT -->
      <mat-sidenav-content>

        <!-- TOP NAVBAR -->
        <mat-toolbar color="primary" class="main-toolbar">
          <span>Project Manager</span>
        </mat-toolbar>

        <!-- PAGE CONTENT -->
        <div class="page-content">
          <router-outlet></router-outlet>
        </div>

      </mat-sidenav-content>

    </mat-sidenav-container>
  `,
  styles: [`
    .sidenav-container {
      height: 100vh;
    }
    .sidenav {
      width: 220px;
    }
    .main-toolbar {
      position: sticky;
      top: 0;
      z-index: 10;
    }
    .page-content {
      padding: 20px;
    }
  `]
})
export class DashboardLayoutComponent {}
