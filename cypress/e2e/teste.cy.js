describe('template spec', () => {
  it('passes', () => {
    cy.visit('http://127.0.0.1:8000')
    cy.get('#email').type('luiz@teste.com')
    cy.get('#password').type('1234')
    cy.get('#login').click()
    cy.wait(200)
    cy.location('pathname').should('eq', '/dashboard')
    cy.get(':nth-child(3) > form > #valor').type('30')
    cy.wait(500)
    cy.get(':nth-child(3) > form > .w-full > button[type=submit]').click()
    cy.wait(500)
    cy.get(':nth-child(4) > form > #valor').type('30')
    cy.wait(500)
    cy.get(':nth-child(4) > form > .w-full > button[type=submit]').click()
    cy.wait(1000)
    cy.get('[value="2"] > .text-2xl').click()
    cy.get('#convertido').click()
    cy.wait(1000)
    cy.get('[value="1"] > .text-2xl').click()
    cy.get('#convertido').click()
    cy.wait(1000)
    cy.get('[value="4"] > .text-2xl').click()
    cy.get('#convertido').click()
    cy.wait(1000)
    cy.get('[value="3"] > .text-2xl').click()
    cy.get('#convertido').click()
    cy.wait(1000)
    cy.get('.h-full > .font-bold').click()
    cy.wait(200)
    cy.location('pathname').should('eq', '/')
  })
})