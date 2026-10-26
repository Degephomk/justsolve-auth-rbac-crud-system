import { Component, OnInit, inject } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Router } from '@angular/router';
import { AuthService } from '../../services/auth';
import { MaterialModule } from '../../shared/material/material-module';

interface User {
  id: number;
  name: string;
  email: string;
  role: string;
}

@Component({
  standalone: true,
  imports: [CommonModule, MaterialModule],
  templateUrl: './settings.html',
  styleUrls: ['./settings.css']
})
export class SettingsComponent implements OnInit {

  private auth = inject(AuthService);
  private router = inject(Router);

  user!: User;

  ngOnInit(): void {
    this.loadUser();
  }

  loadUser() {
    const storedUser = this.auth.getUser(); // ← loads from localStorage

    if (!storedUser) {
      alert('User not logged in');
      this.router.navigate(['/login']);
      return;
    }

    this.user = storedUser;
  }

  logout() {
    this.auth.logout().subscribe();
  }
}
