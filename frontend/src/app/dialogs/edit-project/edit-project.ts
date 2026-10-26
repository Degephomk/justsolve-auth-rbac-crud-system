import { Component, Inject, inject } from '@angular/core';
import { MAT_DIALOG_DATA, MatDialogRef } from '@angular/material/dialog';
import { FormGroup, FormControl, Validators, ReactiveFormsModule } from '@angular/forms';
import { ProjectService } from '../../services/project';
import { MaterialModule } from '../../shared/material/material-module';
import { CommonModule } from '@angular/common';
import { MatSnackBar } from '@angular/material/snack-bar';

@Component({
  standalone: true,
  imports: [CommonModule, MaterialModule, ReactiveFormsModule],
  templateUrl: './edit-project.html',
  styleUrls: ['./edit-project.css']
})
export class EditProjectDialogComponent {

  private projectService = inject(ProjectService);
  private snack = inject(MatSnackBar);
  dialogRef = inject(MatDialogRef<EditProjectDialogComponent>);

  form: FormGroup;

  constructor(@Inject(MAT_DIALOG_DATA) public project: any) {
    this.form = new FormGroup({
      name: new FormControl<string>(project.name, {
        nonNullable: true,
        validators: [Validators.required]
      }),
      description: new FormControl<string>(project.description ?? '', {
        nonNullable: true
      }),
      status: new FormControl<string>(project.status, {
        nonNullable: true,
        validators: [Validators.required]
      })
    });
  }

  update() {
    if (this.form.invalid) return;

    this.projectService.updateProject(this.project.id, this.form.value).subscribe({
      next: () => {
        this.snack.open('Project updated!', 'OK', { duration: 2000 });
        this.dialogRef.close(true);
      },
      error: () => {
        this.snack.open('Update failed', 'OK', { duration: 2000 });
      }
    });
  }
}
