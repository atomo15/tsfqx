import pytest
import System

#This test program created by Synhiranakkrakul,Thunnathorne

#Test if the program can handle a wrong username
def test_login(grading_system):
    username = 'akend3'
    password =  '123454321'
    grading_system.login(username,password)
    assert grading_system.usr.name == username

#Test checking password
def test_check_password(grading_system):
    name = 'akend3'
    passwordEntered = '123454321'
    assert grading_system.check_password(name, passwordEntered)
    name = 'hdjsr7'
    passwordEntered = 'pass1234'
    assert grading_system.check_password(name, passwordEntered)
    name = 'yted91'
    passwordEntered = 'imoutofpasswordnames'
    assert grading_system.check_password(name, passwordEntered)
    name = 'goggins'
    passwordEntered = 'augurrox'
    assert grading_system.check_password(name, passwordEntered)
    name = 'saab'
    passwordEntered = 'boomr345'
    assert grading_system.check_password(name, passwordEntered)
    name = 'calyam'
    passwordEntered = '#yeet'
    assert grading_system.check_password(name, passwordEntered)
    name = 'cmhbf5'
    passwordEntered = 'bestTA'
    assert grading_system.check_password(name, passwordEntered)
 
#test try to change grade by login as professor
def test_change_grade(grading_system):
    grading_system.login('goggins', 'augurrox')
    assert grading_system.usr.change_grade('akend3', 'software_engineering', 'assignment1', 100)

#test try to create assignment as professor
def test_create_assignment(grading_system):
    grading_system.login('goggins', 'augurrox')
    assert grading_system.usr.create_assignment('assignment3', '04/01/20', 'cloud_computing')
  
#test try to add student on the course by professor
def test_add_student(grading_system):
    grading_system.login('goggins', 'augurrox')
    assert grading_system.usr.add_student('yted91', 'databases')
    
#test try to drop student from the course by professor
def test_drop_student(grading_system):
    grading_system.login('goggins', 'augurrox')
    assert grading_system.usr.drop_student('akend3', 'databases')

#test try to submit an assignment by user (student)
def test_submit_assignment(grading_system):
    grading_system.login('hdjsr7', 'pass1234')
    assert grading_system.usr.submit_assignment('cloud_computing', 'assignment1','Blahhhhh', '03/01/20')
    
#test checking ontime of assignment
def test_check_ontime(grading_system):
    grading_system.login('akend3', '123454321')
    assert grading_system.usr.check_ontime('1/5/20','1/6/20') == True

#test try to check grades by student
def test_check_grades(grading_system):
    grading_system.login('hdjsr7', 'pass1234')
    assert grading_system.usr.check_grades('software_engineering')
  
#test try to view the assignment by student
def test_view_assignments(grading_system):
    grading_system.login('hdjsr7', 'pass1234')
    assert grading_system.usr.view_assignments('databases')
    
#addition function

#test add student on course by TA
def test_ta_add_student(grading_system):
    grading_system.login('cmhbf5', 'bestTA')
    assert grading_system.usr.add_student('yted91', 'databases')
 
#test check grades of student by TA
def test_ta_check_grades(grading_system):
    grading_system.login('cmhbf5', 'bestTA')
    assert grading_system.usr.check_grades('yted91','databases')

#test drop student by TA
def test_ta_drop_student(grading_system):
    grading_system.login('cmhbf5', 'bestTA')
    assert grading_system.usr.drop_student('akend3', 'databases')

#test try to submit assignment as TA
def test_ta_submit_assignment(grading_system):
    grading_system.login('cmhbf5', 'bestTA')
    assert grading_system.usr.submit_assignment('cloud_computing', 'assignment1','Blahhhhh', '03/01/20')

#test try to create assignment as TA
def test_ta_create_assignment(grading_system):
    grading_system.login('cmhbf5', 'bestTA')
    assert grading_system.usr.create_assignment('assignment3', '04/01/20', 'cloud_computing')
    

@pytest.fixture
def grading_system():
    gradingSystem = System.System()
    gradingSystem.load_data()
    return gradingSystem
