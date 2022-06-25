<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]
            ->forgetCachedPermissions();

        //create permissions    
        $addUser = 'add user';
        $editUser = 'edit user';
        $deleteUser = 'delete user';

        $addCategory = 'add category';
        $editCategory = 'edit category';
        $deleteCategory = 'delete category';

        $addSkill = 'add skill';
        $editSkill = 'edit skill';
        $deleteSkill = 'delete skill';

        $addExam = 'add exam';
        $editExam = 'edit exam';
        $deleteExam = 'delete exam';
        $viewExam = 'view exam';

        $addQuestion = 'add question';
        $editQuestion = 'edit question';
        $deleteQuestion = 'delete question';

        $addOption = 'add option';
        $editOption = 'edit option';
        $deleteOption = 'delete option';

        $addAnswer = 'add answer';
        $editAnswer = 'edit answer';
        $deleteAnswer = 'delete answer';

        //Create permissions for users
        Permission::create(['name' => $addUser]);
        Permission::create(['name' => $editUser]);
        Permission::create(['name' => $deleteUser]);

        //Create permissions for categories
        Permission::create(['name' => $addCategory]);
        Permission::create(['name' => $editCategory]);
        Permission::create(['name' => $deleteCategory]);

        //Create permissions for skills
        Permission::create(['name' => $addSkill]);
        Permission::create(['name' => $editSkill]);
        Permission::create(['name' => $deleteSkill]);

        //Create permissions for exams
        Permission::create(['name' => $addExam]);
        Permission::create(['name' => $editExam]);
        Permission::create(['name' => $deleteExam]);

        //Create permissions for questions
        Permission::create(['name' => $addQuestion]);
        Permission::create(['name' => $editQuestion]);
        Permission::create(['name' => $deleteQuestion]);

        //Create permissions for options
        Permission::create(['name' => $addOption]);
        Permission::create(['name' => $editOption]);
        Permission::create(['name' => $deleteOption]);

        //Create permissions for answers
        Permission::create(['name' => $addAnswer]);
        Permission::create(['name' => $editAnswer]);
        Permission::create(['name' => $deleteAnswer]);

        /*
        //Permission for a candidate
        Permission::create(['name' => $viewExam]);
        */

        // create roles and assign created permissions

        $superAdmin = 'super-admin';
        $systemAdmin = 'employee';
        $candidate = 'candidate';

        Role::create(['name' => $superAdmin])
            ->givePermissionTo(Permission::all());
        
        Role::create(['name' => $systemAdmin])
            ->givePermissionTo([

                //$addUser,
                //$editUser,
                //$deleteUser,

                $addCategory,
                $editCategory,
                $deleteCategory,

                $addSkill,
                $editSkill,
                $deleteSkill,

                $addExam,
                $editExam,
                $deleteExam,

                $addQuestion,
                $editQuestion,
                $deleteQuestion,

                $addOption,
                $editOption,
                $deleteOption,

                $addAnswer,
                $editAnswer,
                $deleteAnswer, 

            ]);

            
            Role::create(['name' => $candidate])
            ->givePermissionTo([
                //$viewExam,

            ]);  
    }
}
